<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ichtrojan\Otp\Otp;

class OTPModel extends Model
{
    use HasFactory;


    public function getOTP($email){
        $otp = new Otp;
        $response = $otp->generate($email,6,5);

        return $response->token;
    }

    public function verifyOTP($email, $token){
        $otp = new Otp;
        $response = $otp->validate($email, $token);

        return $response;
    }
}
