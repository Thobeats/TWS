<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(){
        $user = Auth::user();
        $cart = Cart::where("user_id", $user->id)->first();

        if(!$cart){

            //toastr()->error("No item in cart");

            return redirect()->back();
        }
        return view('market.cart',compact('user', 'cart'));
    }

    public function store(Request $request){
        try{
            $user = Auth::user();

            // Validate the Cart Item
            $validated = Validator::make($request->only('product_id', 'quantity', 'variants'),[
                                        "product_id" => "required|integer|exists:products,id",
                                        "quantity"=> "required|numeric",
                                        "variants" => "required|string"
                                    ]);

            // CHeck if the quantity is still available
            $product = Product::find($request->product_id);

            $num_in_stock = $product->quantityAvailable($request->color, $request->size);

            if ($num_in_stock < $request->quantity)
            {
                //toastr()->error("Quantity ordered is more than the available stock quantity");
                return redirect()->back();
            }

            // Check if the the product, color and size has been added already

            $check = Cart::where(['product_id' => $request->product_id, 'color' => $request->color, 'size' => $request->size, 'user_id' => $user->id])->first();

            if ($check){
                $check->quantity += $request->quantity;
                $check->price = $check->quantity *  $product->price;
                $check->save();
            }else{

                $cart = new Cart;
                $cart->user_id = $user->id;
                $cart->vendor_id = $product->vendor_id;
                $cart->product_id = $request->product_id;
                $cart->quantity = $request->quantity;
                $cart->color = $request->color;
                $cart->size = $request->size;
                $cart->price = $product->price * $request->quantity;
                $cart->shipping_fee = $product->shipping_fee;
                $cart->save();
            }

            //toastr()->success('Added to Cart');
            return redirect()->back();


        }catch(Exception $e){
            //Load error page
        }
    }

    public function setCartSession(Request $request){

        if (gettype($request->cartId) == 'string'){
            $cartID = json_decode($request->cartId,true);

            $request->merge(["cartId" => $cartID]);
        }

        $request->session()->put(['cartId' => $request->cartId]);

        return redirect('/checkout');
    }
}
