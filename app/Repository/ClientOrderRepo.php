<?php

namespace App\Repository;

use App\Interface\CrudRepoInterface;
use App\Models\ClientOrder;

class ClientOrderRepo implements CrudRepoInterface
{
    public function store($request)
    {
        $clientId = auth()->guard('client')->id();
        if (ClientOrder::where('client_id', $clientId)->where('post_id', $request->post_id)->exists()) {
            return response()->json(['message' => 'error'], 406);
        }
        $data = $request->all();
        $data['client_id'] = $clientId;
        $order = ClientOrder::create($data);
        return response()->json(['message' => 'success']);
    }

    public function workerOrders()
    {
        $orders = ClientOrder::with('post', 'client')->whereStatus('pending')->whereHas('post', function ($query) {
            $query->where('worker_id', auth()->guard('worker')->id());
        })->get();
        return response()->json([
            "orders" => $orders
        ]);
    }

    public function update($id, $request)
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

    public function approvedOrders()
    {
        $orders = ClientOrder::with('post')->whereStatus('approved')->where('client_id', auth()->guard('client')->id())->get();
        return response()->json([
            "orders" => $orders
        ]);
    }
}
