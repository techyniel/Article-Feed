@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2>
                            {{  $article->title }} <small>by {{ $article->user->name }}</small>

                            <a href="{{ url('admin/articles') }}" class="btn btn-default pull-right">Go Back</a>
                        </h2>
                    </div>

                    <div class="panel-body">
                        <p>{{  $article->body }}</p>

                        <p><strong>Category: </strong>{{  $article->category->name }}</p>
                        <p><strong>Tags: </strong>{{ $article->tags->implode('name', ', ') }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
