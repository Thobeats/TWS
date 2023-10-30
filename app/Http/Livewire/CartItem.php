<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Livewire\Component;

class CartItem extends Component
{
    public $user;
    public $items;
    public $sum;
    public $shipping_fee;
    public $cart_id;


    public function mount()
    {
        $this->getCartItems();
    }

    public function getCartItems()
    {
        $user_id = $this->user->id;
        $this->items = Cart::where('user_id', $this->user->id)->select('vendor_id', 'id')
                        ->get()
                        ->map(function($item)use($user_id){
                            $cartItems = Cart::where(['user_id' => $user_id, 'vendor_id' => $item->vendor_id])
                                                 ->get()
                                                 ->toArray();
                            $vendorName = User::find($item->vendor_id);

                            return [
                                "vendor_id" => $item->vendor_id,
                                "vendor_name" => $vendorName->business_name,
                                "cartItems" => $cartItems,
                                "product_id" => $item->product_id
                            ];
                        });
        $this->sum = Cart::where('user_id', $this->user->id)->sum('price');
        $this->shipping_fee = Cart::where('user_id', $this->user->id)->sum('shipping_fee');
        $this->cart_id = json_encode(array_column($this->items->toArray(), 'id'));
    }

    public function Increase($id){
       $cartItem = Cart::find($id);
       $product = Product::find($cartItem->product_id);
       $cartItem->quantity += 1;
       $cartItem->price = $cartItem->quantity * $product->price;
       $cartItem->save();

       $this->getCartItems();
    }

    public function Decrease($id){
        $cartItem = Cart::find($id);
        $product = Product::find($cartItem->product_id);
        $cartItem->quantity -= 1;
        $cartItem->price = $cartItem->quantity * $product->price;
        $cartItem->save();

        $this->getCartItems();
    }

    public function remove($id){
        $cartItem = Cart::find($id);
        $cartItem->delete();

        $this->getCartItems();
    }

    //Move to WishList

    public function render()
    {
        return view('livewire.cart-item');
    }
}
