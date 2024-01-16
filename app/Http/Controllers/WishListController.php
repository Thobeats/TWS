<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\WishListCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class WishListController extends Controller
{
    public function add($id){
        try{
            $user = Auth::user();

            // CHeck if the product exist
            $product = Product::find($id);

            if (!$product){
                return [
                    "code" => 1,
                    "type" => "success",
                    "body" => "Product does not exist"
                ];
            }

            // Remove if the Product is the Wishlist
            $product = Wishlist::where('product_id', $id)->first();

            if ($product){
                /// remove product from Wishlist
                $removeWishList = Wishlist::destroy($product->id);
                $count = Wishlist::where('user_id', $user->id)->count();

                return [
                    "code" => 0,
                    "type" => "success",
                    "count" => $count,
                    "body" => "Product Removed from your wish list"
                ];
            }

            /// Add the Product to the Wishlist
            $newWishList = Wishlist::create([
                "user_id" => $user->id,
                "wish_category_id" => 0,
                "product_id" => $id
            ]);

            if ($newWishList){
                $count = Wishlist::where('user_id', $user->id)->count();
                return [
                    "code" => 0,
                    "type" => "success",
                    "count" => $count,
                    "body" => "Product Added to your wish list"
                ];
            }

        }catch(QueryException $ex){
            return [
                "code" => 2,
                "type" => "database exception error",
                "body" => "Please try again"
            ];

            // Send an email to tech support

        }catch(Exception $e){
            return [
                "code" => 2,
                "type" => "exception error",
                "body" => "Please try again"
            ];

            //Send an email for tech support
        }

    }

    public function remove($id){
        try{
            $user = Auth::user();

            // CHeck if the product exist
            $record = Wishlist::find($id);

            if (!$record){
                //toastr()->error("Record does not exist", "Error");
                return redirect('/customer/wishlists');
            }

            /// remove product from Wishlist
            $removeWishList = Wishlist::destroy($id);

            //toastr()->success("Product Removed from your Wish list", "Success");
            return redirect('/customer/wishlists');
        }catch(QueryException $ex){
            return [
                "code" => 2,
                "type" => "database exception error",
                "body" => "Please try again"
            ];

            // Send an email to tech support

        }catch(Exception $e){
            return [
                "code" => 2,
                "type" => "exception error",
                "body" => "Please try again"
            ];

            //Send an email for tech support
        }
    }

    public function getWishList(){
        try{
            $user = Auth::user();
            // Get all products in wishlist
            $allProducts = Wishlist::where('user_id', $user->id)
                            ->leftjoin('wish_list_categories', 'wishlists.wish_category_id', '=', 'wish_list_categories.id')
                            ->join('products', 'wishlists.product_id', '=', 'products.id')
                            ->select('wishlists.*', 'products.name', 'products.pics')
                            ->get();
            $li = "";

            if ($allProducts->count()){
                foreach($allProducts as $key => $prd){
                    $li .= "<li class='header-cart-item flex-w flex-t m-b-12'>
                                <div class='header-cart-item-img'>
                                    <img src='" . url('storage/products/'. json_decode($prd->pics,true)[0]) . "' alt='IMG' width='100px'>
                                </div>

                                <div class='header-cart-item-txt p-t-8'>
                                    <a href='#' class='header-cart-item-name m-b-18 hov-cl1 trans-04'>
                                        $prd->name
                                    </a>
                                </div>
                            </li>";
                }
            }

            return $li;

        }catch(Exception $e){

        }
    }

    public function allWishList(){
        try{
            $user = Auth::user();

            // Get all products in wishlist
            $allProducts = Wishlist::where('user_id', $user->id)
                            ->leftjoin('wish_list_categories', 'wishlists.wish_category_id', '=', 'wish_list_categories.id')
                            ->join('products', 'wishlists.product_id', '=', 'products.id')
                            ->select('wishlists.*', 'products.name', 'products.pics', 'wish_list_categories.category_name')
                            ->get();
            $allCategories = WishListCategory::where('created_by', $user->id)->get();
            $link = 'saved_items';
            return view('customer.wishlists.all', compact('user', 'allProducts', 'allCategories', 'link'));

        }catch(QueryException $ex){

            return [
                "code" => 2,
                "type" => "database exception error",
                "error" => $ex->getMessage(),
                "body" => "Please try again"
            ];

            // Send an email to tech support

        }catch(Exception $e){
            return [
                "code" => 2,
                "type" => "exception error",
                "body" => "Please try again"
            ];

            //Send an email for tech support
        }
    }

    public function allCategory(){
        $user = Auth::user();
        $allCategories = WishListCategory::where('created_by', $user->id)->get();
        return view('customer.wishlists.all_category', compact('allCategories', 'user'));
    }

    public function saveNewCategory(Request $request){
        try{
            $user = Auth::user();
            parse_str($request->getContent(), $formData);
            $request = new Request($formData);

            // Validate the Request
            $validator = Validator::make($request->all(), [
                "category_name" => "required|string"
            ]);

            if ($validator->fails()){
                return [
                    "code" => 2,
                    "type" => "error",
                    "body" => $validator->errors()
                ];
            }

            // Add New Wishlist Category
            $newWishListCategory = WishListCategory::create([
                "created_by" => $user->id,
                "category_name" => $request->category_name
            ]);

            if ($newWishListCategory){
                //toastr()->success('New Category Added', 'success');
                return [
                    "code" => 0,
                    "type" => "success",
                    "body" => "New Category Added"
                ];
            }

        }catch(QueryException $ex){
            return [
                "code" => 2,
                "type" => "database exception error",
                "body" => "Please try again"
            ];

            // Send an email to tech support

        }catch(Exception $e){
            return [
                "code" => 2,
                "type" => "exception error",
                "body" => "Please try again"
            ];

            //Send an email for tech support
        }
    }

    public function addWishListToCategory(Request $request, $wishlistId){
        try{
            $user = Auth::user();

             // Validate the Request
             $validator = Validator::make($request->all(), [
                "category_id" => "required|integer"
            ]);

            if ($validator->fails()){
                //toastr()->error('Category is invalid', 'error');
                return redirect('/customer/wishlists');
            }

            // Check if the wishlist exist already
            $wishlist = Wishlist::find($wishlistId);

            if (!$wishlist){
                //toastr()->error('Wishlist does not exist', 'error');
                return redirect('/customer/wishlists');
            }

            if ($request->category_id == 0){
                // Add The Wishlist to the new category
                $wishlist->wish_category_id = $request->category_id;
                $wishlist->save();
                //toastr()->success("WishList added to general", 'success');
            }else{
                // Check if the category exist
                $category = WishListCategory::where(['id' => $request->category_id, 'created_by' => $user->id])->first();

                if (!$category){
                    //toastr()->error('Category does not exist', 'error');
                    return redirect('/customer/wishlists');
                }

                // Add The Wishlist to the new category
                $wishlist->wish_category_id = $request->category_id;
                $wishlist->save();
                //toastr()->success("WishList added to $category->category_name", 'success');
            }


            return redirect('/customer/wishlists');
        }catch(QueryException $ex){
            return [
                "code" => 2,
                "type" => "database exception error",
                "body" => "Please try again"
            ];

            // Send an email to tech support

        }catch(Exception $e){
            return [
                "code" => 2,
                "type" => "exception error",
                "body" => "Please try again"
            ];

            //Send an email for tech support
        }
    }
}
