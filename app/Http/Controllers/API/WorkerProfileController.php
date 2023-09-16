<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Worker;
use App\Models\WorkerReview;
use App\Services\UpdateProfileService;

class WorkerProfileController extends Controller
{
    public function userProfile() 
    {
        $workerId = auth()->guard('worker')->id();
        $worker = Worker::with('posts.reviews')->find($workerId)->makeHidden('status','verification_token','verified_at');
        $reviews = WorkerReview::whereIn('post_id',$worker->posts()->pluck('id'));
        $rate = round($reviews->sum('rate') / $reviews->count(),1);
        $mergedData = array_merge($worker->toArray(),['rate' => $rate]);
        $data['data'] = $mergedData;
        // $data['data'] = $worker;
        // $data['reviews'] = round($avarageReviews, 1);
        return response()->json($data);
    }

    public function edit() 
    {
        $data['worker'] = Worker::find(auth()->guard('worker')->id());
        return response()->json($data);
    }

    public function update(UpdateProfileRequest $request) 
    {
        return (new UpdateProfileService)->update($request);    
    }
}
