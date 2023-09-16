<?php

namespace App\Http\Controllers\API;

use App\Filters\PostFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StorePostRequest;
use App\Models\Post;
use App\Services\Post\StoringPost;

use Spatie\QueryBuilder\QueryBuilder;

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
        // ->allowedFilters(['price', 'content','worker.name'])
        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters((new PostFilter)->filter())
            ->with('worker:id,name')
            ->whereStatus('approved')
            ->get(['id','content','price','worker_id']);
            // ->makeHidden('status');

        // $posts = Post::with('worker:id,name')->whereStatus('approved')->get()->makeHidden('status');

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
