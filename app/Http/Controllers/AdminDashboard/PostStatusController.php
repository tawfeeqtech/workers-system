<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\PostStatusRequest;
use App\Models\Post;
use App\Notifications\AdminPost;
use Illuminate\Support\Facades\Notification;

// use Illuminate\Http\Request;

class PostStatusController extends Controller
{

    function changeStatus(PostStatusRequest $request)
    {
        $post = Post::find($request->post_id);
        $post->update([
            'status' => $request->status,
            'rejected_reason' => $request->rejected_reason
        ]);
        Notification::send($post->worker, new AdminPost($post->worker, $post));
        return response()->json([
            'message' => 'change Status success'
        ]);
    }
}
