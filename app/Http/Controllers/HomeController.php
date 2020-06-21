<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Articles;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles      = Articles::count();
        $comments   = Comment::count();
        $tags       = Tag::count();
        $categories = Category::count();

        return view('states', get_defined_vars());
    }


    
}
