<?php

namespace App\Http\Controllers;

use App\Models\VendorSubscription;
use App\Traits\AppTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorSubscribe extends Controller
{
    use AppTrait;

    public function index(){

    }

    public function subscribe($vendor_id){
        try{
            $user = Auth::user();

            // Subscribe the Customer to the Vendor
            // Check if the customer has subscribed already
            $checkSub = VendorSubscription::where(['vendor_id' => $vendor_id, 'customer_id' => $user->id])->first();

            if ($checkSub){
                $checkSub->delete();
                return [
                    "code" => 1,
                    "body" => "You have unsubscribed from this vendor"
                ];
            }

            //Create a new subscription
            $newSub = VendorSubscription::create([
                "vendor_id" => $vendor_id,
                "customer_id" => $user->id
            ]);


            // Notify the Vendor of the new Subscription
            $this->notifyUser("You have a new Suscription","",$vendor_id,"info","New Subscription");

            return [
                "code" => 0,
                "body" => "Subscribed"
            ];

        }catch(Exception $e){
            info($e->getMessage());
            info($e);
            return [
                "code" => 2,
                "body" => $e->getMessage()
            ];
        }
    }

    public function unsubscribe(){

    }


}
