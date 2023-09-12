<?php

namespace App\Services;

class BothLogin
{
    public function isValidData($guard, $data)
    {
        $token = auth()->guard($guard)->attempt($data->validated());

        if (!$token) {
            return false;
        }
        return $token;
    }

    function createNewToken($guard, $token)
    {
        return response()->json([
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ],
            'user' => auth()->guard($guard)->user()
        ]);
    }

    function getStatus($model, $email)
    {
        $entity = $model->whereEmail($email)->first();
        if ($entity) {
            return $entity->status;
        }
    }

    function isVerified($model, $email)
    {
        $entity = $model->whereEmail($email)->first();
        if ($entity) {
            return $entity->verified_at;
        }
    }
}
