<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ClientOrderRequset;
use App\Interface\CrudRepoInterface;

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
        return $this->crudRepo->workerOrders();
    }

    public function updateOrder($id, Request $request)
    {
        return $this->crudRepo->update($id, $request);
    }

    public function approvedOrders()
    {
        return $this->crudRepo->approvedOrders();
    }
}
