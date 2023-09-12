<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterClientRequest;
use App\Models\Client;
use App\Services\Both;
use App\Services\Client\Login\ClientLoginService;
use App\Services\Client\Register\ClientRegisterService;
use Illuminate\Support\Facades\Auth;

class ClientAuthController extends Controller
{
    protected $model;
    public function __construct()
    {
        $this->middleware('auth:client', ['except' => ['login', 'register','verify']]);
        $this->model = new Client;
    }

    public function login(LoginRequest $request)
    {
        return (new ClientLoginService())->login($request);
    }

    public function verify($token)
    {
        return (new Both())->verify($this->model,$token);
    }

    public function register(RegisterClientRequest $request)
    {
        return (new ClientRegisterService())->register($request);
    }

    public function logout()
    {
        Auth::guard('client')->logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::guard('client')->user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
