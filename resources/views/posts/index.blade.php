@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($posts as $post)
                <div class="panel panel-default">
                    <div class="panel-heading">{{$post->title}}</div>

                    <div class="panel-body">
                        {{$post->subtitle}}
                    </div>

                    <div class="panel-footer">
                        Author: {{$post->user->name}} |
                        <a href={{route('posts.show',$post->id)}}>See more...</a>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection