<?php

namespace App\Models;

use Carbon\Carbon;
use Ichtrojan\Otp\Otp;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OTPModel extends Model
{
    use HasFactory;

    protected $table = 'otps';


    public function getOTP($email){
        $response = $this->generate_otp($email,6,5);
        return $response->token;
    }

    public function verifyOTP($email, $token){
        $response = $this->validate($email, $token);

        return $response;
    }

    private function generatePin($digits = 4)
    {
        $i = 0;
        $pin = "";

        while ($i < $digits) {
            $pin .= random_int(0, 9);
            $i++;
        }

        return $pin;
    }

    private function generate_otp(string $identifier,$length=6){
        self::where('identifier', $identifier)->delete();

        $token = $this->generatePin($length);

        DB::table('otps')->insert([
            'identifier' => $identifier,
            'token' => $token,
            'validity' => 5,
            'valid' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return (object)[
            'status' => true,
            'token' => $token,
            'message' => 'OTP generated'
        ];
    }



    public function validate(string $identifier, int $token){

        $otp = self::where('identifier', $identifier)->where('token', $token)->first();

        if ($otp == null) {
            return (object)[
                'status' => false,
                'message' => 'OTP does not exist'
            ];
        } else {
            if ($otp->valid == true) {
                $carbon = new Carbon;
                $now = $carbon->now();
                $validity = Carbon::parse($otp->created_at)->addMinutes($otp->validity);

                if (strtotime($validity) < strtotime($now)) {
                    $otp->valid = false;
                    $otp->save();

                    return (object)[
                        'status' => false,
                        'message' => 'OTP Expired'
                    ];
                } else {
                    $otp->valid = false;
                    $otp->save();

                    return (object)[
                        'status' => true,
                        'message' => 'OTP is valid'
                    ];
                }
            } else {
                return (object)[
                    'status' => false,
                    'message' => 'OTP is not valid'
                ];
            }
        }
    }
}
