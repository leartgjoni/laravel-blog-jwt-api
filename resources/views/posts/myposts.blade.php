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
                            <a href={{route('posts.edit',$post->id)}} class="btn btn-default">Edit</a>
                            {{ Form::open([
                                            'method'=>'DELETE',
                                            'url' => route('posts.destroy', ['id'=>$post->id]),
                                            'style' => 'display:inline']) }}
                            {{ Form::submit('Delete', ['class' => 'btn btn-danger delete-confirm']) }}
                            {{Form::close()}}
                            <a href={{route('posts.show',$post->id)}}>See more...</a>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection