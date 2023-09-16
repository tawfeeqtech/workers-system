<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Post;
use App\Models\Worker;
use App\Models\WorkerReview;
use App\Services\UpdateProfileService;

class WorkerProfileController extends Controller
{
    protected $workerId;
    public function __construct()
    {
        $this->workerId = auth()->guard('worker')->id();
    }

    public function userProfile()
    {
        $worker = Worker::with('posts.reviews')->find($this->workerId);
        $reviews = WorkerReview::whereIn('post_id', $worker->posts()->pluck('id'));
        $rate = round($reviews->sum('rate'),1);
        if($reviews->count() > 0){
            $rate = round($reviews->sum('rate') / $reviews->count(), 1);
        }
        
        $mergedData = array_merge($worker->toArray(), ['rate' => $rate]);
        $data['data'] = $mergedData;
        // $data['data'] = $worker;
        // $data['reviews'] = round($avarageReviews, 1);
        return response()->json($data);
    }

    public function edit()
    {
        $data['worker'] = Worker::find($this->workerId);
        return response()->json($data);
    }

    public function update(UpdateProfileRequest $request)
    {
        return (new UpdateProfileService)->update($request);
    }

    public function delete()
    {
        Post::where('worker_id', $this->workerId)->delete();
        return response()->json(['message' => 'deleted']);
    }
}
