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
}
