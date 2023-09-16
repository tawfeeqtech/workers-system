<?php

namespace App\Interface;

interface CrudRepoInterface
{
    public function store($data);
    public function workerOrders();
    public function update($id, $request);
    public function approvedOrders();
}
