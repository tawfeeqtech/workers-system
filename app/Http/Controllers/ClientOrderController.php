<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientOrderRequset;
use App\Models\ClientOrder;

// use Illuminate\Http\Request;

class ClientOrderController extends Controller
{
    public function addOrder(ClientOrderRequset $requset)
    {
        $clientId = auth()->guard('client')->id();
        if (ClientOrder::where('client_id', $clientId)->where('post_id', $requset->post_id)->exists()) {
            return response()->json(['message' => 'error'], 406);
        }
        $data = $requset->all();
        $data['client_id'] = $clientId;
        $order = ClientOrder::create($data);
        return response()->json(['message' => 'success']);
    }
}
