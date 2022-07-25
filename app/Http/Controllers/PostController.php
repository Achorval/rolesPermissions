<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::all();

        return response()->json([
            'posts' => $post,
            'status' => true,
            'Message' => 'Post retrieved successfully!'
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        if ($request->user()->cannot('create-post')) {
            return response()->json([
                'status' => false,
                'Message' => 'Not authorized to create this post!'
            ], 401); 
        };

        $post = Post::create([
            "user_id" => auth()->id(),
            "title" => $request->title,
            "description" => $request->description
        ]);

        return response()->json([
            'post' => $post,
            'status' => true,
            'Message' => 'Post created successfully!'
        ], 200); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostRequest $request, Post $post)
    {
        if ($request->user()->cannot('update-post', $post)) {
            return response()->json([
                'status' => false,
                'Message' => 'Not authorized to update this post!'
            ], 401); 
        };

        $post->update([
            "user_id" => auth()->id(),
            "title" => $request->title,
            "description" => $request->description
        ]);

        return response()->json([
            'post' => $post,
            'status' => true,
            'Message' => 'Post updated successfully!'
        ], 200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    { 
        if (\Auth::user()->cannot('delete-post', $post)) {
            return response()->json([
                'status' => false,
                'Message' => 'Not authorized to delete this post!'
            ], 401); 
        };

        $post->delete();

        return response()->json([
            'status' => true,
            'Message' => 'Post deleted successfully!'
        ], 200);
    }
}
