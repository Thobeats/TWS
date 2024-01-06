<?php

namespace App\View\Composers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Variant;
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
            $variants = Variant::where('status', 1)->get();

            $wquery = Wishlist::where('user_id', auth()->user()->id);
            $wcount = $wquery->count();
            $wishlists = $wquery->get();
            $view->with(compact('count', 'wcount', 'cart', 'sum', 'wishlists','variants'));
        }

        $galleries = Product::where('publish_status', 1)
                                ->inRandomOrder()
                                ->get();
        $view->with(compact('galleries'));

    }
}

