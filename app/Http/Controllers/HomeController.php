<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Chat;
use App\Models\User;
use App\Models\Order;
use App\Models\Slide;
use App\Models\Banner;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\VendorReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function register(Request $request){
        try{
            if($request->isMethod('get')){
                return "Register";
            }else{
                // Validate and Register a new User
                $validator = Validator::make($request->all(), [
                    'email' => 'required|email',
                    'firstname' => 'required|string',
                    'lastname' => 'required|string',
                    'password' => 'required|string',
                    'confirm_password' => 'required|same:password',
                ]);
            }

        }catch(Exception $e){

        }
    }

    public function home(){
        $slides = Slide::where('status', 1)->get();
        $categories = Category::where('parent_to_children.parent_id', 0)
                            ->join('parent_to_children', 'parent_to_children.category_id', '=', 'categories.id')
                            ->limit(6)
                            ->get();
        $vendors = User::where('role', 2)->select('id', 'business_name as name')->get();
        $sections = Section::where(['status'=>1,'for' => 2])->orderBy('position')->get();
        $adminSections = Section::where(['status'=> 1,'for' => 3])->orderBy('position')->get();
        $new_arrivals = Product::select('*')
                                ->where('publish_status',1)
                                ->orderBy('id', 'DESC')
                                ->limit(10)
                                ->get();
        // $topVendors = Order::selectRaw("count(orders.vendor_id) as cnt, users.business_name, users.profile, users.id, vendors.business_banner")
        //                     ->join('users','users.id','=','orders.vendor_id')
        //                     ->join('vendors', 'vendors.user_id', '=', 'orders.vendor_id')
        //                     ->groupBy('users.id', 'vendors.business_banner')
        //                     ->orderBy('cnt', 'DESC')
        //                     ->limit(5)
        //                     ->get()
        //                     ->map(function($item){
        //                         $products = Product::where('vendor_id', $item->id)->limit(5)->get()->toArray();

        //                         return [
        //                             "vendor_id" => $item->id,
        //                             "business_name" => $item->business_name,
        //                             "profile" => $item->profile,
        //                             "business_banner" => $item->business_banner,
        //                             "products" => $products
        //                         ];
        //                     });
        $topVendors = Vendor::selectRaw("users.business_name, users.profile, users.id, vendors.business_banner")
                            ->join('users','users.id','=','vendors.user_id')
                            ->groupBy('users.id', 'vendors.business_banner')
                            ->orderBy('users.id', 'DESC')
                            ->limit(5)
                            ->get()
                            ->map(function($item){
                                $products = Product::where('vendor_id', $item->id)->limit(5)->get()->toArray();
                                return [
                                    "vendor_id" => $item->id,
                                    "business_name" => $item->business_name,
                                    "profile" => $item->profile,
                                    "business_banner" => $item->business_banner,
                                    "products" => $products
                                ];
                            });

        // $spotLight = Vendor::whereIn()
        //                     ->join('users','users.id','=','vendors.user_id')
        //                     ->groupBy('users.id', 'vendors.business_banner')
        //                     ->orderBy('users.id', 'DESC')
        //                     ->limit(5)
        //                     ->get()
        //                     ->map(function($item){
        //                         $products = Product::where('vendor_id', $item->id)->limit(5)->get()->toArray();
        //                         return [
        //                             "vendor_id" => $item->id,
        //                             "business_name" => $item->business_name,
        //                             "profile" => $item->profile,
        //                             "business_banner" => $item->business_banner,
        //                             "products" => $products
        //                         ];
        //                     });


        return view('market.home',compact('vendors','sections','new_arrivals', 'adminSections','topVendors', 'categories'));
    }

    public function shop(){
        $vendors = User::where('role', 2)->select('id', 'business_name as name')->get();
        return view('market.shop',compact('vendors'));
    }

    public function addToWishList($id){

    }

    public function saveChat(Request $request){
        try{
            $validate = Validator::make($request->all(),[
                'recipient' => 'required|integer',
                'from' => 'required|integer',
                'message' => 'required|string'
            ]);

            if($validate->fails()){
                return ['code' => 1, "message" => $validate->errors()];
            }

            $msg = $request->all();

            // Save in the Database
            $vendor = $msg['source'] == 'vendor' ? $msg['from'] : $msg['recipient'];
            $customer = $msg['source'] == 'customer' ? $msg['from'] : $msg['recipient'];

            // Chat structure: from,message,time.
            $chat_message = [
                'from' => $msg['source'],
                'message' => $msg['message'],
                'time' => $msg['time']
            ];

            // Get the previous messages
            $query = Chat::where([
                        "vendor_id" => $vendor,
                        "customer_id" => $customer
                    ])->first();

            if($query){
                $all_messages = json_decode($query->chat_message, true);
            }

            $all_messages[] = $chat_message;

            $chatInsert = Chat::updateOrCreate(
                [
                    "vendor_id" => $vendor,
                    "customer_id" => $customer
                ],
                [
                    'chat_message' => json_encode($all_messages),
                    'vendor_read_status' => 0,
                    'customer_read_status' => 1
                ]
            );

            return ['code' => 1, "message" => $chatInsert];

        }catch(Exception $e){

        }
    }

    public function vendors(){
        return view('market.vendors');
    }

    public function vendor(Request $request, $id){
        $vendor = Vendor::where('vendors.user_id', $id)
                        ->join('users', 'users.id', '=', 'vendors.user_id')
                        ->first();

        $category = $vendor->products;

        $cProducts = Category::whereIn('id', json_decode($category,true))
                                    ->get()
                                    ->map(function($items)use($id){
                                        $products = Product::whereJsonContains('category_id', "$items->id")
                                                            ->where('vendor_id', $id)
                                                            ->where('publish_status', 1)
                                                            ->select('name', 'pics', 'id')
                                                            ->get()
                                                            ->toArray();
                                        return [
                                            "category_name" => $items->name,
                                            "products" => $products
                                        ];
                                    });
        $step = $request->step ? $request->step : 'about';

        return view('market.vendor',compact('id', 'vendor', 'cProducts', 'step'));
    }

    public function saveVendorRating(Request $request){
        $validator = Validator::make($request->all(),[
           "comment" => 'nullable|string',
           "rating" => 'required|integer',
           "vendor_id" => 'required|integer|exists:vendors,user_id'
        ],
        [
            "rating.required" => "Please rate the vendor",
            "vendor_id.exists" => "This vendor doesn't exist"
        ]);

        if($validator->fails()){
           return redirect()->back()->withErrors($validator->errors());
        }

        $user = Auth::user();

        // Save into Vendor Reviews
        $saveNew = VendorReview::create([
            "from" => $user->id,
            "vendor_id" => $request->vendor_id,
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

        return redirect("/market/vendor/$request->vendor_id?step=review");
    }

    public function subscribeVendor(){

    }
}
