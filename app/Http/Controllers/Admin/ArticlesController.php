<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\ArticlesRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with(['user', 'category', 'tags', 'comments'])->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id')->all();
        $tags = Tag::pluck('name', 'name')->all();

        return view('admin.articles.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest  $request )
    {
        $article = Articles::create([
            'title'       => $request->title,
            'body'        => $request->body,
            'category_id' => $request->category_id
        ]);

        $tagsId = collect($request->tags)->map(function($tag) {
            return Tag::firstOrCreate(['name' => $tag])->id;
        });

       $article->tags()->attach($tagsId);
        flash()->overlay('Article created successfully.');

        return redirect('/admin/articles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $article = $article->load(['user', 'category', 'tags', 'comments']);

        return view('admin.articles.show', compact('articles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        if($article->user_id != auth()->user()->id && auth()->user()->is_admin == false) {
            flash()->overlay("You can't edit other peoples articles.");
            return redirect('/admin/articles');
        }

        $categories = Category::pluck('name', 'id')->all();
        $tags = Tag::pluck('name', 'name')->all();

        return view('admin.articles.edit', compact('articles', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        // disbust cache
        Cache::forget($articles->etag);

        $article->update([
            'title'       => $request->title,
            'body'        => $request->body,
            'category_id' => $request->category_id
        ]);

        $tagsId = collect($request->tags)->map(function($tag) {
            return Tag::firstOrCreate(['name' => $tag])->id;
        });

        $article->tags()->sync($tagsId);
        flash()->overlay('articles updated successfully.');

        return redirect('/admin/articles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $articl)
    {
        if($article->user_id != auth()->user()->id && auth()->user()->is_admin == false) {
            flash()->overlay("You can't delete other peoples articles.");
            return redirect('/admin/articles');
        }

        $article->delete();
        flash()->overlay('Article deleted successfully.');

        return redirect('/admin/articles');
    }

    public function publish( Article $article)
    {
        $article->is_published = !$article->is_published;
        $article->save();
        flash()->overlay('articles changed successfully.');

        return redirect('/admin/articles');
    }


  
}
