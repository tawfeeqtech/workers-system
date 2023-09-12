<?php

namespace App\Services\Worker\Register;

use App\Models\Worker;
use App\Services\Both;
use App\Services\BothRegister;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class WorkerRegisterService extends BothRegister
{
    protected $model;

    function __construct()
    {
        $this->model = new Worker;
    }

    function store($request)
    {
        $entity = $this->model->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'photo' => $request->file('photo')->store('workers'),
            'location' => $request->location,
        ]);
        return $entity->email;
    }

    function register($request)
    {
        try {
            DB::beginTransaction();
            (new Both())->validation($request);
            // $this->validation($request);
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
