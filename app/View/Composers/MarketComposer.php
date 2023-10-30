<?php

namespace App\View\Composers;
 
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
 
class MarketComposer
{
 
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::user()){
            $count = Cart::where('user_id', auth()->user()->id)->count();

            $cart = Cart::where('user_id', auth()->user()->id)->get();

            $sum = Cart::where('user_id', auth()->user()->id)->sum('price');
        
            $wishList = Wishlist::where('user_id', auth()->user()->id)->first();
            if($wishList){
                $wcount = count(json_decode($wishList->items,true));
            }else{
                $wcount = 0;
            }

            $view->with(compact('count', 'wcount', 'cart', 'sum'));
            
        }
       
    }
}

