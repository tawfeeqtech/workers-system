<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Post;
use App\Models\WorkerCashe;
use Illuminate\Support\Facades\DB;

class ClientPaymentController extends Controller
{
    public function payment($serviceId)
    {
        // return view('payment', [
        //     'payLink' => Client::first()->charge(12.99, 'Action Figure')
        // ]);   
        try {
            DB::beginTransaction();
            $post = Post::find($serviceId);
            $paylink =  auth()->guard('client')->user()->charge($post->price, $post->content);
            $workerCash = WorkerCashe::create([
                'post_id' => $post->id,
                'client_id' => Client::first()->id,
                'total' => $post->price
            ]);
            DB::commit();
            return \response()->json(['paylink' => $paylink], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([$e->getMessage()]);
        }
    }
}
