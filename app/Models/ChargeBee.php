<?php

namespace App\Models;

use Illuminate\Http\Request;
use ChargeBee\ChargeBee\Environment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use ChargeBee\ChargeBee\Models\HostedPage;
use ChargeBee\ChargeBee\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChargeBee extends Model
{
    use HasFactory;

    public function __construct(){
        Environment::configure("nuday-test","test_TWYZLd9RFbCMV1wIa5MNDTh2Ab65qVhJ");
    }

    public function subscribe(Request $request){
        // Save the User Details and subscription
        // return [
        //     "subscriptionItems" => array(
        //       "itemPriceId" => $request->get('itemPriceId')
        //     ),
        //     "customer" => array(
        //         "first_name" => $request->get('first_name'),
        //         "last_name" => $request->get('last_name'),
        //         "company" => $request->get('company'),
        //         "phone" => $request->get('phone'),
        //         "email" => $request->get('email')
        //     )
        // ];
        $validator = Validator::make($request->all(),[
            'itemPriceId' => 'required|integer',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'business_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string'
        ]);

        $result = HostedPage::checkoutOneTimeForItems(array(
            "shippingAddress" => array(
              "firstName" => "John",
              "lastName" => "Mathew",
              "city" => "Walnut",
              "state" => "California",
              "zip" => "91789",
              "country" => "US"
              ),
            "customer" => array(
              "id" => "__test__XpbXKKYSOUtL5p2E"
              ),
            "itemPrices" => array(array(
              "itemPriceId" => "cbdemo_advanced-USD-monthly",
              "unitPrice" => 750))
            ));

        $hostedPage = $result->hostedPage();
        return response()->json($hostedPage->getValues(), 200);

    }

}
