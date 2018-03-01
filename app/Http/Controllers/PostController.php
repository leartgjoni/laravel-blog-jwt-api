<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Auth;
use Validator;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        if ($request->is('api/*')) {
            return response()->json($posts);
        }
        return ($this->isApi($request))? $this->returnToApi($posts) : view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'subtitle' => 'required|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return ($this->isApi($request))? $this->returnToApi($validator->errors()->all(),400) : redirect('posts/create')->withErrors($validator)->withInput();
        }

        $post = new Post();
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->body = $request->body;
        $post->user_id = Auth::user()->id;
        $post->save();

        return ($this->isApi($request))? $this->returnToApi(["message"=>"Post successfully created"]) : redirect()->route('posts.show',$post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $post = Post::findOrFail($id);

        return ($this->isApi($request))? $this->returnToApi($post) : view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $post = Post::findOrFail($id);
        if($post->user_id != $this->getUser($request)->id){
            return redirect()->route('/');
        }

        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if($post->user_id != $this->getUser($request)->id){
            return ($this->isApi($request))? $this->returnToApi(['message'=>'unauthorized'],401) : redirect()->route('/');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'subtitle' => 'required|max:255',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return ($this->isApi($request))? $this->returnToApi($validator->errors()->all(),400) : redirect(route('posts.update',$post->id))->withErrors($validator)->withInput();
        }

        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->body = $request->body;
        $post->save();

        return ($this->isApi($request))? $this->returnToApi(['message'=>'Post Updated Successfully']) :  redirect()->route('posts.show',$post->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        if($post->user_id != $this->getUser($request)->id){
            return ($this->isApi($request))? $this->returnToApi(['message'=>'unauthorized'],401) : redirect()->route('/');
        }

        $post->delete();

        return ($this->isApi($request))? $this->returnToApi(['message'=>'Post deleted successfully']):redirect()->route('posts.myposts');
    }

    public function myposts(Request $request){
        $user = $this->getUser($request);
        $user_id = $user->id;
        $posts = Post::where('user_id',$user_id)->orderBy('created_at', 'desc')->get();

        return ($this->isApi($request))? $this->returnToApi($posts):view('posts.myposts',compact('posts'));
    }
}
