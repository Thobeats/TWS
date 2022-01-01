<?php

namespace App\Traits;

use App\Models\SecretKey;
use App\Mail\ConfirmEmail;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp as OTP;
use App\Mail\ConfirmEmailMarkdown;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use \Stripe\StripeClient as Stripe;


trait AppTrait{

    protected function success(){

    }

    protected function error(){

    }

    protected function uploadFile(Request $request,$key,$path){
        $fileModel = new File;
        $fileName = $request->file($key)->getClientOriginalName();
        $destination = storage_path("app/public/$path");

        if(file_exists($destination . "/" . $fileName)){
            return false;
        }
        $filePath = $request->file($key)->storeAs($path, $fileName, 'public');

        return $filePath;
    }

    protected function sendConfirmEmail($email,$token){
      //  Mail::to($email)->send(new ConfirmEmailMarkdown($token));
    }

    protected function generateUserCode(){
        return strtotime('now');
    }

    public function initialiseStripe(){
        $key = new SecretKey;
        $stripe = new Stripe($key->getSecret());
        return $stripe;
    }
}



