@extends('layouts.app')

@section('content')
    <div class="container">

        @include('frontend._search')

        <div class="row">

            <div class="col-md-12">
                @forelse ($articles as $post)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ $articles->title }} - <small>by {{ $articles->user->name }}</small>

                            <span class="pull-right">
                                {{ $articles->created_at->toDayDateTimeString() }}
                            </span>
                        </div>

                        <div class="panel-body">
                            <p>{{ str_limit($articles->body, 200) }}</p>
                            <p>
                                Tags:
                                @forelse ($articles->tags as $tag)
                                    <span class="label label-default">{{ $tag->name }}</span>
                                @empty
                                    <span class="label label-danger">No tag found.</span>
                                @endforelse
                            </p>
                            <p>
                                <span class="btn btn-sm btn-success">{{ $articles->category->name }}</span>
                                <span class="btn btn-sm btn-info">Comments <span class="badge">{{ $post->comments_count }}</span></span>

                                <a href="{{ url("/articles/{$articles->id}") }}" class="btn btn-sm btn-primary">See more</a>
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="panel panel-default">
                        <div class="panel-heading">Not Found!!</div>

                        <div class="panel-body">
                            <p>Sorry! No post found.</p>
                        </div>
                    </div>
                @endforelse

                <div align="center">
                    {!! $articles->appends(['search' => request()->get('search')])->links() !!}
                </div>

            </div>

        </dev>
    </dev>
@endsection
