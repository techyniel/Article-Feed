<?php

namespace App\Http\Controllers\Api;

use App\Models\Articles;
use Illuminate\Http\Request;
use App\Http\Resources\ArticlesResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ArticlesController extends Controller
{
    public function index(Request $request)
    {
        $articles = Articles::when($request->title, function($query) use ($request) {
            return $query->where('title', 'like', "%{$request->title}%");
        })
        ->when($request->search, function($query) use ($request) {
            return $query->where('title', 'like', "%{$request->search}%")
                         ->orWhere('body', 'like', "%{$request->search}%");
        })
        ->when($request->order, function($query) use ($request) {
            if($request->order == 'oldest') {
                return $query->oldest();
            }
            return $query->latest();
        }, function($query) {
            return $query->latest();
        })
        ->when($request->status, function($query) use ($request) {
            if($query->status == 'published') {
                return $query->published();
            }
            return $query->drafted();
        })
        ->paginate($request->get('limit', 10));

        return ArticlesResource::collection($articles);
    }

    public function show(Articles $articles)
    {
        Cache::put($articles->etag, $articles->id);

        $articles = $articles->load(['category', 'comments.user', 'tags', 'user']);

        return new ArticlesResource($articles);
    }
}
