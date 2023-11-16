<?php

namespace App\Traits;

use App\Models\User;
use App\Models\SecretKey;
use App\Mail\ConfirmEmail;
use Illuminate\Http\Request;
use Ichtrojan\Otp\Otp as OTP;
use App\Mail\ConfirmEmailMarkdown;
use \Stripe\StripeClient as Stripe;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\AppNotification;
use Illuminate\Support\Facades\Notification;


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
      Mail::to($email)->send(new ConfirmEmailMarkdown($token));
    }

    protected function generateUserCode(){
        return strtotime('now');
    }

    public function initialiseStripe(){
        $key = new SecretKey;
        $stripe = new \Stripe\StripeClient($key->getSecret());
        return $stripe;
    }

    protected function notifyUser($message,$ref,$recipientID,$type,$title="New Order"){

        $data = [
            "title" => $title,
            "message" => $message,
            "ref" => $ref,
            "from" => auth()->user()->id,
            "time" => now()->format('l F Y h:i:s '),
            "type" => $type
        ];

        $user = User::find($recipientID);
        Notification::send($user, new AppNotification($data));

        //Send Email to the User
        
    }

    protected function deleteFile($fileName){
        $destination = storage_path("app/public/storage");

        if(file_exists($destination . "/" . $fileName)){
            unlink($destination . "/" . $fileName);

            return true;
        }

        return false;
    }

    protected function changePassword($newPassword, $user){
        $user->password = Hash::make($newPassword);
        $user->save();
    }

    protected function deleteProfileImage(){

    }

    protected function notifyAdmin($title, $message,$ref, $type){
        $admin  = User::where('role', 3)->get();

        // Create the notification
        $data = [
            "title" => "New Message",
            "message" => "I am testing this",
            "ref" => "",
            "from" => 1,
            "time" => now()->format('l F Y h:i:s '),
            "type" => "success"
        ];

        Notification::send($admin, new AppNotification($data));
    }
}



