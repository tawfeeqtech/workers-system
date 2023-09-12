<?php

namespace App\Services\Client\Login;

use App\Models\Client;
use App\Services\Both;
use App\Services\BothLogin;

class ClientLoginService extends BothLogin
{
    protected $model, $guard;
    function __construct()
    {
        $this->model = new Client;
        $this->guard = 'client';
    }

    function login($request)
    {
       // $data = $this->validation($request);
        $data = (new Both())->validation($request);
        $token = $this->isValidData($this->guard, $data);

        if ($token == false) {
            return response()->json([
                'message' => 'Error for this user',
            ], 401);
        }

        $status = $this->getStatus($this->model, $request->email);

        if ($this->isVerified($this->model, $request->email) == null) {
            return response()->json([
                'message' => "your account is not Verified",
            ], 422);
        } else if ($status == '0') {
            return response()->json([
                'message' => "your account is pending",
            ], 422);
        }

        return $this->createNewToken($this->guard, $token);
    }
}
