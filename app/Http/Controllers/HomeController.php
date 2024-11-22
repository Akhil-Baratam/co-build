<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    
    //this method shows home page
    public function index() {
        $popularCategories = DB::table('ideas') 
                       ->select('category', DB::raw('COUNT(category) as count'))
                       ->groupBy('category')
                       ->orderByDesc('count')
                       ->limit(5)
                       ->get();
        $topIdeas = DB::table('ideas')
                       ->orderByDesc('upvotes')  // Order by upvotes in descending order
                       ->limit(6)                 // Limit to top 6
                       ->get();
         

        return view('front.home',[
            'popularCategories' => $popularCategories,
            'topIdeas' => $topIdeas,
        ]);
    }

    public function contact() {
        return view('front.contact');
    }
}
