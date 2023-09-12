<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;

class BothRegister
{
    public function generateToken($model,$email)
    {
        $en_email = md5(rand(0, 9) . $email . time());
        $token = substr($en_email, 0, 32);
        $entity = $model->whereEmail($email)->first();
        $entity->verification_token = $token;
        $entity->save();
        return $entity;
    }

    function sendEmail($entity)
    {
        Mail::to($entity->email)->send(new VerificationEmail($entity));
    }
}
