<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientOrderRequset;
use App\Interface\CrudRepoInterface;
use App\Models\ClientOrder;

use Illuminate\Http\Request;

class ClientOrderController extends Controller
{
    protected $crudRepo;
    public function __construct(CrudRepoInterface $crudRepo)
    {
        $this->crudRepo = $crudRepo;
    }
    public function addOrder(ClientOrderRequset $requset)
    {
        return $this->crudRepo->store($requset);
    }

    public function workerOrder()
    {
        $order = ClientOrder::with('post', 'client')->whereStatus('pending')->whereHas('post', function ($query) {
            $query->where('worker_id', auth()->guard('worker')->id());
        })->get();
        return response()->json(['orders' => $order]);
    }

    public function updateOrder($id, Request $request)
    {

        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);


        $order = ClientOrder::where('id', $id)->whereHas('post', function ($query) {
            $query->where('worker_id', auth()->guard('worker')->id());
        })->first();
        if ($order) {
            $input = $request->only('status');

            $order->setAttribute('status', $input['status'])->save();
            return response()->json(['message' => 'updated']);
        }
        return response()->json(['message' => 'error'], 404);
    }
}
