@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Create Post</div>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="panel-body">
                            {{Form::open(array('route'=>'posts.store'))}}
                            <div class="form-group">
                                {{ Form::label('title', 'title', ['class'=>'form-label']) }}
                                {{ Form::text('title', null, array('class'=>'form-control', 'placeholder'=>'title', 'maxlength'=>'255', 'id'=>'title')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('subtitle', 'Subtitle' , ['class'=>'form-label']) }}
                                {{ Form::text('subtitle', null, array('class'=>'form-control', 'placeholder'=>'Subtitle', 'maxlength'=>'255')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('body', 'Body', ['class'=>'form-label']) }}
                                {{ Form::textarea('body', null, array('id'=>'body-editor','class'=>'form-control', 'placeholder'=>'Body')) }}
                            </div>
                            {{ Form::submit('Create', array('class'=>'btn btn-lg btn-block btn-success', 'style'=>'margin-top:20px')) }}
                            {{Form::close()}}
                        </div>

                    </div>
            </div>
        </div>
    </div>
@endsection