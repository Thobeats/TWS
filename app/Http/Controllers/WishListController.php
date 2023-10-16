<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function add($id){
        $user = Auth::user();

        $user_wishlist = Wishlist::where('user_id',$user->id)->first();

        if(!$user_wishlist){
            $user_wishlist = new Wishlist;
            $user_wishlist->user_id = $user->id;
            $items = [];
        }else{
            $items = json_decode($user_wishlist->items,true);
        }

        $product = Product::find($id);

        if($product){
            //Add Or Remove
            if(in_array($id, $items)){
                unset($items[array_search($id,$items)]);
                $items = array_values($items);

                if(count($items) == 0){
                    $user_wishlist->delete();
                }

                return [
                    "code" => 0,
                    "count" => count($items),
                    "action" => 0
                ];

            }else{
                $items[$id] = [
                    'product_id' => $id,
                    'num_of_product' => 1,
                    'price' => floatval($product->price)
                ];
            }
            $user_wishlist->items = json_encode($items);
            $user_wishlist->save();

            return [
                "code" => 0,
                "count" => count($items),
                "action" => 1
            ];
        }
    }
}
