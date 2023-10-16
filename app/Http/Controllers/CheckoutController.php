<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\Product;
use App\Traits\AppTrait;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    use AppTrait;

    public function checkout(Request $request){
        try{

            $user = User::find(Auth::user()->id);
            $stage = 1;

            if($request->step == 'use_default'){
                $address = $user->address();
                $stage = 2;
            }else if($request->method() == 'POST' && $request->save){

                $messages = [
                    'fname' => 'Please enter a valid name',
                    'lname' => 'Please enter a valid name',
                    'phone' => 'Please enter a valid phone number'
                ];

                $validate = Validator::make($request->all(),[
                    'fname' => 'required|string',
                    'lname' => 'required|string',
                    'phone' => 'required|numeric',
                    'add_phone' => 'nullable|numeric',
                    'delivery_address' => 'required|string',
                    'add_info' => 'nullable|string',
                    'zip' => 'required|string',
                    'country' => 'required|string',
                    'region' => 'required|string'
                ],$messages);

                if($validate->fails()){
                    return redirect('/checkout')->withErrors($validate)->withInput();
                }

                $new_address = $request->only('fname','lname','phone','add_phone','delivery_address','add_info','zip','country','region');

                $user_address = json_decode($user->address, true);
                $user_address[] = $new_address;
                $user->address = json_encode($user_address);
                $user->save();

                $address = $new_address;

                $stage = 2;
            } else{
                $address = [];
            }

            $data = [
                'stage' => $stage,
                'address' => $address
            ];

            return view('market.checkout',compact('data'));
        }catch(Exception $e){
            // return exception route
        }
    }

    public function purchase(){
        $items = session('cartItems');
        $request = new Request($items);

       return view('market.purchase', compact('request'));
    }

    public function process_checkout(Request $request){
        try{
            $user = Auth::user();

            $order_details = $request->all();

            /// Create Payment Intent then save into the Orders Table
            $stripe = $this->initialiseStripe();
            $uniqID = uniqid('ORDER_');
            $intent = $stripe->paymentIntents->create([
                'amount' => $request->total,
                'currency' => 'usd',
                'transfer_group' => $uniqID,
                'automatic_payment_methods' => ['enabled' => true],
                'receipt_email' => $user->email
            ]);

            //Update the Cart with transfer group ID

            $user_cart = Cart::where('user_id',$user->id)->first();

            if($user_cart){
                // Update the product id with the transfer_group key
                $items = json_decode($user_cart->items, true);

                foreach($request->product_id as $prd){
                    if(array_key_exists($prd, $items)){
                        $items[$prd]['transfer_group'] = $uniqID;
                    }
                }

                $user_cart->items = json_encode($items);
                $user_cart->save();
            }
            return $intent;
        }catch(Exception $e){
            return $e->getMessage();
        }

    }

    public function confirm_payment(Request $request){

        $stripe = $this->initialiseStripe();
        $user = Auth::user();

        $user_cart = Cart::where('user_id', $user->id)->first();

        if(!$user_cart){
            return redirect('/shop');
        }

        //if the purchase was successful ...Update Payment Status and add them to Orders ...notify the Vendors
        //Retrieve the Payment Intent
        $intent = $stripe->paymentIntents->retrieve($request->payment_intent);

        $cart_items = json_decode($user_cart->items,true);
        foreach($cart_items as $key => $item){
            if($item['transfer_group'] == $intent->transfer_group){
                $item['payment_status'] = true;

                $product = Product::find($key);

                //Create Order
                Order::create([
                    "vendor_id" =>  $product->vendor_id,
                    "order_number" => $intent->transfer_group,
                    "order_details" => json_encode($item),
                    "total_price" => $item['price'],
                    "customer_id" => $user->id,
                    "reference_number" => uniqid("REF"),
                    "status" => 1
                ]);

                //Initiate Transfer to Vendor
                $vendor = Vendor::where('user_id', $product->vendor_id)->first();
                $accountId = json_decode($vendor->account_details,true);
                // $stripe->transfers->create([
                //     'amount' => $item['price'],
                //     'currency' => 'usd',
                //     'destination' => $accountId['id'],
                //     'transfer_group' => $intent->transfer_group,
                // ]);

                //Remove from the Cart
                unset($cart_items[$key]);
            }
        }

        $user_cart->items = json_encode($cart_items);
        $user_cart->save();

        // Return to Success Page and remove the Session
        $request->session()->forget('cartItems');
        return redirect('/success');
    }

    public function success(){
        return view('market.success');
    }
}
