<?php

namespace App\Services;
use Illuminate\Support\Facades\Validator;

class Both
{
    public function verify($model, $token)
    {
        $entity = $model::whereVerificationToken($token)->first();
        if (!$entity) {
            return response()->json([
                'message' => 'this token is invalid',
            ]);
        }
        $entity->verification_token = null;
        $entity->verified_at = now();
        $entity->save();
        return response()->json([
            'message' => 'your account has been verified',
        ]);
    }

    public function validation($request)
    {
        $validetor = Validator::make($request->all(), $request->rules());
        if ($validetor->fails()) {
            return response()->json($validetor->errors(), 422);
        }
        return $validetor;
    }
}
