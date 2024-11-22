<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\SavedIdea;
use App\Models\Upvote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ideascontroller extends Controller
{
    public function index(Request $request)
    {
        $ideas = Idea::query();

        // Validate request parameters
        $request->validate([
            'keyword' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'idea_type' => 'nullable|string|max:255', // Allow comma-separated idea types
        ]);

        // Search by keyword in title, description, or tags
        if (!empty($request->keyword)) {
            $ideas->where(function ($query) use ($request) {
                $query->where('title', 'like', "%{$request->keyword}%")
                    ->orWhere('description', 'like', "%{$request->keyword}%")
                    ->orWhereJsonContains('tags', $request->keyword); // Handle JSON field for tags
            });
        }

        // Filter by category
        if (!empty($request->category)) {
            $category = trim($request->category);  // Trim any leading/trailing whitespace
            $category = str_replace('%20', ' ', $category);  // Replace '%20' with actual space, if needed
            $ideas->where('category', $category);
        }
        

        $idea_typeArray=[];
        // Filter by idea_type - Handling multiple selections (comma-separated values)
        if (!empty($request->idea_type)) {
            $idea_typeArray = explode(',', $request->idea_type);  // Split the comma-separated values into an array

            // Ensure we are querying based on the values
            $ideas->whereIn('idea_type', $idea_typeArray);  // Use whereIn to handle multiple types
        }

        // Order and paginate
        $ideas = $ideas->orderBy('created_at', 'DESC')->paginate(9);

        // Categories and idea types for the view
        $categories = ['Full stack Website', 'AI SaaS', 'Cloud/DevOps', 'Business Model', 'DevOps & CI/CD Pipelines', 'Augmented Reality (AR) & Virtual Reality (VR)', 'Blockchain & Cryptocurrency', 'Machine Learning & AI'];
        $idea_types = ['Tech & Development', 'Business & Marketing', 'Startup'];

        // Return the view with the data
        return view('front.ideas', [
            'categories' => $categories,
            'ideas' => $ideas,
            'idea_types' => $idea_types,
            'idea_typeArray' => $idea_typeArray
        ]);
    }

    public function detail($id){
        $idea = Idea::with('user', 'upvotes')->findOrFail($id);

        
        $idea = Idea::find($id);
        $userHasUpvoted = Auth::check() && $idea->upvotes()->where('user_id', Auth::id())->exists();

        if($idea == null){
            abort(404);
        }

        return view('front.ideaDetail',[
            'idea' => $idea,
            'userHasUpvoted' => $userHasUpvoted
        ]);
    }

    public function saveIdea(Request $request){
        $id = $request->id;

        $idea = Idea::find($id);

        if($idea == null){
            session()->flash('error','Idea not found');

            return response()->json([
                'status' => false
             ]);
        }


        $count = SavedIdea::where([
            'user_id' => Auth::user()->id,
            'idea_id' => $id
        ])->count();

        if($count > 0){
            session()->flash('error','Idea already saved');

            return response()->json([
               'status' => false
            ]);
        }

        $saveIdea = new SavedIdea;
        $saveIdea->user_id = Auth::user()->id;
        $saveIdea->idea_id = $id;
        $saveIdea->save();

        session()->flash("success",'Idea saved successfully');
        return response()->json([
           'status' => true
        ]);
    }

    public function upvote(Request $request){
        $ideaId = $request->idea_id;

        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'You need to log in to upvote.']);
        }

        $userId = Auth::id();

        // Check if the user has already upvoted
        $existingUpvote = Upvote::where(['user_id' => $userId, 'idea_id' => $ideaId])->first();

        if ($existingUpvote) {
            // If already upvoted, remove the upvote
            $existingUpvote->delete();
            return response()->json(['success' => true, 'message' => 'Upvote removed.']);
        }

        // Otherwise, add the upvote
        Upvote::create(['user_id' => $userId, 'idea_id' => $ideaId]);

        return response()->json(['success' => true, 'message' => 'Idea upvoted successfully.']);
    }

}
