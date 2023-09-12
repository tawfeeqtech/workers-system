<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Services\Post\StoringPost;
// use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(StorePostRequest $storePostRequest)
    {
        return (new StoringPost())->store($storePostRequest);
    }
}
