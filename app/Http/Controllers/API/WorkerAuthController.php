<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Worker;
use App\Services\Both;
use App\Services\Worker\Login\WorkerLoginService;
use App\Services\Worker\Register\WorkerRegisterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WorkerAuthController extends Controller
{
    protected $model;
    public function __construct()
    {
        $this->middleware('auth:worker', ['except' => ['login', 'register', 'verify']]);
        $this->model = new Worker();
    }

    public function login(LoginRequest $request)
    {
        return (new WorkerLoginService())->login($request);
    }

    public function register(RegisterRequest $request)
    {
        return (new WorkerRegisterService())->register($request);
    }

    public function verify($token)
    {
        return (new Both())->verify($this->model, $token);
    }


    /* public function forgetPassword(Request $request)
    {
        try {
            $entity = $this->model->whereEmail($request->email)->get();
            if (count($entity) > 0) {
            } else {
                return response()->json(['success' => false, 'msg' => 'user not found!']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()]);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'requierd|string|min:6|confirmed'
        ]);
        $entity = $this->model::find($request->id);
        $entity->password = Hash::make($request->password);
        $entity->save();
        return response()->json([
            'message' => 'Reset Password Successfully',
        ]);
    } */

    public function logout()
    {
        Auth::guard('worker')->logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::guard('worker')->user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
