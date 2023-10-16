<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index(){
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        $items = json_decode($cart->items,true);

        $sum = array_reduce(array_column(array_values($items),'price'), function($v1, $v2){
            return $v1+$v2;
        });

        $shipping_fee = array_reduce(array_column(array_values($items),'shipping_fee'), function($v1, $v2){
            return $v1+$v2;
        });

        return view('market.cart',compact('items','sum','shipping_fee'));
    }

    public function store(Request $request){
        try{
            $user = Auth::user();
            //Validate the request and add to Cart
            $validated = Validator::make($request->only('product_id','size','color','num_of_product'),[
                                            'product_id' => 'required|integer',
                                            'size' => 'required|integer',
                                            'color' => 'required|integer',
                                            'num_of_product' => 'required|integer'
                                        ]);
            if($validated->fails()){
                return redirect("/market/product/$request->product_id");
            }

            // Add To Cart
            $user_cart = Cart::where('user_id', $user->id)->first();

            if($user_cart){
                $cart_items = json_decode($user_cart->items, true);
            }else{
                $user_cart = new Cart;
                $cart_items = [];
                $user_cart->user_id = $user->id;
            }

            // Check if Product is still valid
            $product = Product::find($request->product_id);

            if(!$product){
                toastr()->error('Product has been removed by the vendor');
                return redirect("/market/product/$request->product_id");
            }

            //Cart Product
            $new_product = [
                'product_id' => $request->product_id,
                'size' => $request->size,
                'color' => $request->color,
                'num_of_product' => $request->num_of_product,
                'price' => floatval($request->num_of_product) * floatval($product->price),
                'shipping_fee' => floatval($request->num_of_product) * floatval($product->shipping_fee)
            ];

            //Check if the Product has been added
            if(array_key_exists($request->product_id,$cart_items)){
                toastr()->error('Product added already');
                return redirect("/market/product/$request->product_id");
            }

            //Append to the List of Cart Items
            $cart_items[$request->product_id] = $new_product;
            $user_cart->items = json_encode($cart_items);
            $user_cart->save();

            toastr()->success('Added to Cart');
            return redirect('/');


        }catch(Exception $e){
            //Load error page
        }
    }

    public function setCartSession(Request $request){
        $request->session()->put(['cartItems' => $request->only('_token','product_id', 'total','shipping_total')]);

        return redirect('/checkout');
    }
}
