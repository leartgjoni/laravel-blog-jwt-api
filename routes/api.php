<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'AuthenticateController@login');
Route::post('signup','AuthenticateController@signup');
Route::get('logout', 'AuthenticateController@logout');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('posts/myposts','PostController@myposts');
    Route::resource('posts', 'PostController', ['except'=>['index','show','create']]);
});

Route::get('/posts','PostController@index');
Route::get('/posts/{id}','PostController@show');




