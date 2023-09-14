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
}
