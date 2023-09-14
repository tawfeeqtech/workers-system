<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Worker\WorkerReviewRequest;
use App\Http\Resources\WorkerReviewResource;
use App\Models\WorkerReview;
use Illuminate\Http\Request;

class WorkerReviewController extends Controller
{
    public function store(WorkerReviewRequest $request)
    {
        $data = $request->only('post_id', 'comment', 'rate');
        $data['client_id'] = auth()->guard('client')->id();
        if ($data['client_id'] === null) {
            return response()->json([
                'message' => "Unauthenticated.",
            ], 401);
        }
        $reviews = WorkerReview::create($data);
        return response()->json([
            'data' => $reviews
        ]);
    }

    public function postRate($id)
    {
        $reviews = WorkerReview::wherePostId($id);

        $avarage = $reviews->sum('rate') / $reviews->count();
        return response()->json([
            'total_rate' => round($avarage, 1),
            'data' => WorkerReviewResource::collection($reviews->get())
        ]);
    }
}
