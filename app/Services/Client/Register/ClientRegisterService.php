<?php

namespace App\Services\Client\Register;

use App\Models\Client;
use App\Services\Both;
use App\Services\BothRegister;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;

class ClientRegisterService extends BothRegister
{
    protected $model;

    function __construct()
    {
        $this->model = new Client();
    }

    function store($request)
    {
        $entity = $this->model->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'photo' => $request->file('photo')->store('clients'),
        ]);
        return $entity->email;
    }

    function register($request)
    {
        try {
            DB::beginTransaction();
            (new Both())->validation($request);
            $email = $this->store($request);
            $entity = $this->generateToken($this->model, $email);
            $this->sendEmail($entity);
            DB::commit();
            return response()->json([
                'message' => "your account has been Created please check your email",
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
