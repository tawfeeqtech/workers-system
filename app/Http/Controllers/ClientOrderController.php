<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientOrderRequset;
use App\Interface\CrudRepoInterface;
use App\Models\ClientOrder;

// use Illuminate\Http\Request;

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
}
