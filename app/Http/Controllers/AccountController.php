<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\SavedIdea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    //THis method will show user registration page
    public function registration() {
        return view('front.account.registration');
    }

    public function processRegistration( Request $request) {
        $validator = Validator::make($request->all(),[
            'name' =>'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:users,email',
            'role' => 'required|in:individual,company',
            'password' => 'required|string|min:6|',
            'confirm_password' => 'required|same:password',
        ]);

        if( $validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success', 'You have successfully created an account');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    //THis method will show user registration page
    public function login() {
        return view('front.account.login');
    }

    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' =>'required|string|email|max:255',
            'password' => 'required|string|min:6|',
        ]);

        if( $validator->passes()) {

            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.profile')->with('success', 'You have successfully logged in');
            } else {
                return redirect()->route('account.login')->with('error', 'Either email/password is incorrect');
            }

        } else {
            return redirect()->route('account.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }
    }

    public function profile() {

        $id = Auth::user()->id;
        $user = User::find($id);

        return view('front.account.profile', [
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request) {
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(),[
            'name' =>'required|string|max:255',
            'email' =>'required|email|max:255|unique:users,email,'.$id.',id'
        ]);

        if ($validator->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();

            session()->flash('success', 'Profile updated successfully');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('home')->with('success', 'You have successfully logged out');
    }

    public function updateProfilePic(Request $request) {
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(),[
            'image' =>'required|image'
        ]);

        if ($validator->passes()) {

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = $id.'-'.time().'.'.$ext;
            $image->move(public_path('/profile_pic/'), $imageName);

            $sourcePath = public_path('/profile_pic/'.$imageName);
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);

            // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
            $image->cover(150, 150);
            $image->toPng()->save(public_path('/profile_pic/thumb/'.$imageName));

            File::delete(public_path('/profile_pic/thumb/'.Auth::user()->image));
            File::delete(public_path('/profile_pic/'.Auth::user()->image));

            User::where('id', $id)->update(['image' => $imageName]);

            session()->flash('success', 'ProfilePic has been updated');

            return response()->json([
                'status' => true,
                 'errors' => []
             ]);

        } else {
            return response()->json([
               'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function createIdea(){
        $categories = ['Full stack Website', 'AI SaaS', 'Cloud/DevOps', 'Business Model', 'DevOps & CI/CD Pipelines', 'Augmented Reality (AR) & Virtual Reality (VR)','Blockchain & Cryptocurrency', 'Machine Learning & AI'];
        // $categories = Idea::distinct()->pluck('category');
        // $categories = DB::table('ideas')->distinct()->pluck('category');
        // ->select('category', DB::raw('COUNT(category) as count'))
        // ->groupBy('category')
        // ->orderByDesc('count')
        // ->get();
        return view('front.account.idea.create', [
                'categories' => $categories
        ]);
    }

    public function saveIdea(Request $request){
        $rules = [
            'title' =>'required|min:4|max:255',
            'category' =>'required',
            'idea_type' =>'required',
            'working_on_it' =>'required',
            'description' =>'required|min:30',
            'tags' =>'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->passes()){

            $idea = new Idea();
            $idea->title = $request->title;
            $idea->category = $request->category;
            $idea->idea_type = $request->idea_type;
            $idea->working_on_it = $request->working_on_it;
            $idea->description = $request->description;
            $idea->relevant_links = $request->relevant_links;
            $idea->tags = json_encode($request->tags);
            $idea->user_id = Auth::id(); // Assign the authenticated user's ID


            $idea->save();

            session()->flash('success', 'Idea added successfully');

            return response()->json([
                'status' => true,
                 'errors' => []
             ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    
    public function myIdeas(){
        $ideas = Idea::where('user_id',Auth::user()->id)->orderBy('created_at', 'DESC')->simplePaginate(10);
        return view('front.account.idea.my-ideas',[
            'ideas' => $ideas
        ]);
    }

    public function editIdea(Request $request, $id){
        $idea = Idea::where([
        'id' => $id,
        'user_id' => Auth::user()->id
        ])->first();
        
        if($idea == null) {
            abort(404);
        }
        
        return view('front.account.idea.edit', [
            'idea' => $idea
        ]);
    }

    public function updateIdea(Request $request, $id){
        $rules = [
            'title' =>'required|min:4|max:255',
            'category' =>'required',
            'idea_type' =>'required',
            'working_on_it' =>'required',
            'description' =>'required|min:30',
            'tags' =>'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->passes()){

            $idea = Idea::find($id);
            $idea->title = $request->title;
            $idea->category = $request->category;
            $idea->idea_type = $request->idea_type;
            $idea->working_on_it = $request->working_on_it;
            $idea->description = $request->description;
            $idea->relevant_links = $request->relevant_links;
            $idea->tags = json_encode($request->tags);
            $idea->user_id = Auth::id(); // Assign the authenticated user's ID


            $idea->save();

            session()->flash('success', 'Idea updated successfully');

            return response()->json([
                'status' => true,
                 'errors' => []
             ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function deleteIdea(Request $request){
        $idea = Idea::where([
            'id' => $request->ideaId,
            'user_id' => Auth::user()->id
        ])->first();

        if($idea == null) {
            session()->flash('error','Either deleted or not found');
            return response()->json([
               'status' => true,
                'errors' => []
            ]);
        }

        Idea::where('id', $request->ideaId)->delete();
        session()->flash('error','Idea deleted successfully');
        return response()->json([
           'status' => true,
            'errors' => []
        ]);
    }

    public function savedIdeas(){
        $savedIdeas = SavedIdea::where(['user_id' => Auth::user()->id])->orderBy('created_at', 'DESC')->simplePaginate(10);
        return view('front.account.idea.saved-ideas',[
            'savedIdeas' => $savedIdeas
        ]);
    }

    public function removeSavedIdea(Request $request){
        $savedIdea = SavedIdea::where([
            'id' => $request->id,
            'user_id' => Auth::user()->id
        ])->first();

        if($savedIdea == null) {
            session()->flash('error','Either deleted or not found');
            return response()->json([
               'status' => true,
            ]);
        }

        SavedIdea::find($request->id)->delete();
        session()->flash('error','Idea removed from saved list successfully');
        return response()->json([
           'status' => true,
        ]);
    }

    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);

        if($validator->fails()){
            return response()->json([
               'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        if(Hash::check($request->old_password, Auth::user()->password) == false){
            session()->flash('error', 'Your old password is incorrect');
            return response()->json([
               'status' => true,
            ]);
        }

        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->new_password);
        $user->save();

        session()->flash('success', 'Password updated successfully');
        return response()->json([
           'status' => true,
        ]);
    }
}
    