<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StorePostRequest;
use App\Models\Post;
use App\Services\Post\StoringPost;
// use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'posts' => $posts
        ]);
    }

    public function approved()
    {
        $posts = Post::whereStatus('approved')->get()->makeHidden('status');
        
        return response()->json([
            'posts' => $posts
        ]);
        
    }

    public function viewPost($postId) 
    {
        $post = Post::whereId($postId)->first();
        return response()->json([
            'post' => $post
        ]);
    }

    public function store(StorePostRequest $storePostRequest)
    {
        return (new StoringPost())->store($storePostRequest);
    }
}
