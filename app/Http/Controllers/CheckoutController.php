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

            $item = session('cartId');

            $query = Cart::whereIn('id', $item);

            $items['total'] = $query->sum('price');
            $items['shipping_total'] = $query->sum('shipping_fee');

            return view('market.checkout',compact('data', 'items'));
        }catch(Exception $e){
            // return exception route
        }
    }

    public function purchase(Request $request){
        $items = session('cartId');
       return view('market.purchase', compact('request'));
    }

    public function process_checkout(Request $request){
        try{
            $user = Auth::user();
            $item = session('cartId');
            $query = Cart::whereIn('id', $item);
            $total = $query->sum('price') + $query->sum('shipping_fee');

            /// Create Payment Intent then save into the Orders Table
            $stripe = $this->initialiseStripe();
            $uniqID = uniqid('ORDER_');
            $intent = $stripe->paymentIntents->create([
                'amount' => $total,
                'currency' => 'usd',
                'transfer_group' => $uniqID,
                'automatic_payment_methods' => ['enabled' => true],
                'receipt_email' => $user->email
            ]);

            //Create Session with Transfer Group ID
            $request->session()->put(['transferGroupId' => $uniqID]);
            return $intent;
        }catch(Exception $e){
            return $e->getMessage();
        }

    }

    public function confirm_payment(Request $request){

        $stripe = $this->initialiseStripe();
        $user = Auth::user();

        if (!$request->session()->has('transferGroupId')){
            return redirect('/');
        }

        //if the purchase was successful ...Update Payment Status and add them to Orders ...notify the Vendors
        //Retrieve the Payment Intent
        $intent = $stripe->paymentIntents->retrieve($request->payment_intent);

        if ($intent->status == 'succeeded'){
            $item = session('cartId');
            $transferGroupId = session('transferGroupId');
            $query = Cart::whereIn('id', $item);

            $products = $query->get();

            foreach ($products as $product){
                $refno = uniqid("REF");
                $orderedProduct = Product::find($product->product_id);
                $orderDetails = [
                    "price" => $product->price + $product->shipping_fee,
                    "size" => $product->size,
                    "color" => $product->color,
                    "quantity" => $product->quantity,
                    "payment_status" => 1
                ];
                // Save the Orders into the Orders Table
                //Create Order
                Order::create([
                    "vendor_id" =>  $orderedProduct->vendor_id,
                    "order_number" => $transferGroupId,
                    "order_details" => json_encode($orderDetails),
                    "total_price" => $product->price + $product->shipping_fee,
                    "customer_id" => $user->id,
                    "reference_number" => $refno,
                    "status" => 1
                ]);

                //Initiate Transfer to Vendor
                $vendor = Vendor::where('user_id', $product->vendor_id)->first();
                $accountId = json_decode($vendor->account_details,true);
                $stripe->transfers->create([
                    'amount' => $product->price + $product->shipping_fee,
                    'currency' => 'usd',
                    'destination' => $accountId['id'],
                    'transfer_group' => $intent->transfer_group,
                ]);


                // Notify the Vendor
                $message = "New Order From $user->firstname $user->lastname";
                $type = "info";
                $recipientID = $product->vendor_id;
                $this->notifyUser($message,$refno,$recipientID,$type,$title="New Order");

                // Remove From the Cart
                $product->delete();
            }

        }else{
             // Notify the User
             $message = "Order not succesful, Payment Failed";
             $type = "danger";
             $recipientID = $user->id;
             $this->notifyUser($message,"",$recipientID,$type,$title="Payment Failed");

             $request->session()->forget('cartId');
             $request->session()->has('transferGroupId');
             return redirect('/error');
        }

        // Return to Success Page and remove the Session
        $request->session()->forget('cartId');
        $request->session()->has('transferGroupId');
        return redirect('/success');
    }

    public function success(){
        return view('market.success');
    }

    public function error(){
        toastr()->error('Payment Failed');
        return redirect('/');
    }
}
