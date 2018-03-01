<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'PostController@index');

Auth::routes();

Route::group(['middleware'=>'auth'],function() {
    Route::get('posts/myposts',['uses'=>'PostController@myposts','as'=>'posts.myposts']);
    Route::resource('posts','PostController',['except'=>['index','show']]);
});
Route::resource('posts','PostController',['only'=>['index','show']]);
