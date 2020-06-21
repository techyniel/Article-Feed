<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::when($request->search, function($query) use($request) {
                        $search = $request->search;
                        
                        return $query->where('title', 'like', "%$search%")
                            ->orWhere('body', 'like', "%$search%");
                    })->with('tags', 'category', 'user')
                    ->withCount('comments')
                    ->published()
                    ->simplePaginate(5);

        return view('frontend.index', compact('articles'));
    }

    public function article(Article $article)
    {
        $article = $article->load(['comments.user', 'tags', 'user', 'category']);

        return view('frontend.articles', compact('articles'));
    }

    public function comment(Request $request, Article $article)
    {
        $this->validate($request, ['body' => 'required']);

        $articles->comments()->create([
            'body' => $request->body
        ]);
        flash()->overlay('Comment successfully created');

        return redirect("/articles/{$articles->id}");
    }
}
