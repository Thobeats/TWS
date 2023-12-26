<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\Chat;
use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use App\Traits\AppTrait;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\VendorSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use AppTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try{
            $user = Auth::user();
            $product = Product::find($id);
            $step = $request->step ? $request->step : "";

            $data = [];

            //Check if subscribed
            $check = VendorSubscription::where(['customer_id' => $user->id, 'vendor_id' => $product->vendor_id])->first();

            if($product){

                $chat = Chat::where([
                    'customer_id' => $user->id,
                    'vendor_id' => $product->vendor_id
                ])->first();

                if(!$chat){
                    $chats = [];
                }else{
                    $chats = json_decode($chat->chat_message,true);
                }

                $colors =[];

                if (!is_null($product->item_listing())){
                foreach($product->item_listing() as $key => $value){
                        $color = Color::find($key);
                        $listing = $this->getItemsByColor($product->id,$color->id);

                        $colors[] = [
                            'name' => $color->name,
                            'id' => $color->id,
                            'listing' => $listing
                        ];
                }
                }

                $data = [
                    'product'=> $product,
                    'images' => $product->images(),
                    'item' => $colors,
                    'user' => $user,
                    'chats' => $chats,
                    'productId' => $product->id,
                    'check' => $check,
                    'step' => $step
                ];
                // dd($data);
                return view('market.product',$data);
            }
        }catch(Exception $e){

        }
    }


    public function getItemsByColor($productId, $colorId){
        $product = Product::find($productId);
        $listing = json_decode($product->item_listing,true);
        $item = $listing[$colorId];
        $items = []; $i = 0;
        foreach($item[0] as $size){
            $sizes = Size::find($size);

            $items[] = [
                'size' => $sizes->size_code,
                'size_id' => $sizes->id,
                'no_in_stock' => $item[1][$i],
                'price' => isset($item[2]) ? $item[2][$i] : $product->price
            ];
            $i++;
        }
        return $items;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function purchase(Request $request){
       try{
            //Initialize Stripe Session
            $stripe = $this->initialiseStripe();

            $checkout = $stripe->checkout->sessions->create([

            ]);


       }catch(Exception $e){
        //Return Exception page
       }
    }

    public function saveProductRating(Request $request){
        try{
            $validator = Validator::make($request->all(),[
                "comment" => 'required|string',
                "rating" => 'required|integer',
                "product_id" => 'required|integer|exists:products,id'
             ],
             [
                 "rating.required" => "Please rate the vendor",
                 "product_id.exists" => "This product doesn't exist"
             ]);

             if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors());
             }

             $user = Auth::user();

             // Save into Vendor Reviews
                $saveNew = ProductReview::create([
                 "from" => $user->id,
                 "product_id" => $request->product_id,
                 "comment" => $request->comment,
                 "rating" => $request->rating
                ]);

             if(!$saveNew)
             {
                toastr()->error('Review not saved');
             }
             else
             {
                toastr()->success('Thank You');
             }

             return redirect("/market/product/$request->product_id?step=reviews");

        }catch(Exception $e){
            
        }
    }


}
