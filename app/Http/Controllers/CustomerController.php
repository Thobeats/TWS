<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Chat;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(){

        $user = Auth::user();
        $vendors = User::where('role', 2)->select('id', 'business_name as name')->get();
        $link = 'dashboard';
        return view('customer.dashboard', compact('user','vendors', 'link'));
    }

    public function orders(Request $request){
        $user = Auth::user();
        $link = 'orders';

        if($request->has('filter')){
            if(!$request->month and !$request->status){
                toastr()->error('No filter values');

                return redirect()->back();
            }

            $query = Order::where("orders.customer_id", $user->id);

            if($request->month){
                $query = $query->whereMonth('orders.created_at', $request->month);
            }

            if($request->status){
                $query = $query->where('orders.status', $request->status);
            }

            //dd($query);
            $orders =  $query->join('users', 'users.id', '=', 'orders.vendor_id')
                            ->join('products', 'products.id', '=', 'orders.order_details->product_id')
                            ->join('order_status', 'order_status.id', '=', 'orders.status')
                            ->select('orders.id', 'products.pics','orders.total_price',
                                    'orders.status','users.id as user_id', 'users.firstname',
                                    'users.lastname','orders.order_details->num_of_product as num_products',
                                    'order_status.name as status',
                                    'orders.status as status_id',
                                    'orders.order_details->product_id as prodID')
                            ->orderBy('orders.created_at', 'desc')
                            ->paginate(5);

        }else{
            $orders = Order::where("orders.customer_id", $user->id)
            ->join('users', 'users.id', '=', 'orders.vendor_id')
            ->join('products', 'products.id', '=', 'orders.order_details->product_id')
            ->join('order_status', 'order_status.id', '=', 'orders.status')
            ->select('orders.id', 'products.pics','orders.total_price',
                    'orders.status','users.id as user_id', 'users.firstname',
                    'users.lastname','orders.order_details->num_of_product as num_products',
                    'order_status.name as status',
                    'orders.status as status_id',
                    'orders.order_details->product_id as prodID')
            ->orderBy('orders.created_at', 'desc')
            ->paginate(5);
        }



        $months = Order::select(DB::raw('MONTHNAME(created_at) as month, MONTH(created_at) as month_id'))
                            ->groupBy(DB::raw('MONTHNAME(created_at),MONTH(created_at)'))
                            ->get();
        $status = DB::table('order_status')->select('id','name')->get();

        $offset = ($orders->currentPage() - 1) * $orders->perPage();
        return view('customer.orders', compact('orders', 'offset','months','status','user', 'link'));
    }

    public function editPersonalDetails(Request $request){

        $validator = Validator::make($request->only('firstname','lastname'),[
            'firstname' => 'required|string',
            'lastname' => 'required|string'
        ]);

        if($validator->fails()){
            toastr()->error($validator->errors()->first());
            return redirect('/customer/profile');
        }

        $user = Auth::user();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->save();

        toastr()->success('Update Successful');
        return redirect('/customer/profile');
    }

    public function newAddress(){
        return view('customer.new_address');
    }

    public function saveAddress(Request $request){
        $user = Auth::user();
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'phone' => 'required|numeric',
            'add_phone' => 'nullable|numeric',
            'delivery_address' => 'required|string',
            'add_info' => 'nullable|string',
            'zip' => 'required|string',
            'country' => 'required|string',
            'region' => 'required|string'
        ]);

        $address = json_decode($user->address, true);
        $address[] = $request->all();
        $user->address = json_encode($address);
        $user->save();

        toastr()->success('New Address Saved');

        return redirect('/customer/address');
    }

    public function address(){
        $user = Auth::user();
        $link = "address";
        return view('customer.address',compact('user', 'link'));
    }

    public function editAddress($index){
        $user = Auth::user();
        $address = json_decode($user->address, true);
        $add = $address[$index];
        return view('customer.edit_address', ['index' => $index, 'address' => $add]);
    }

    public function deleteAddress($index){
        $user = Auth::user();
        $address = json_decode($user->address, true);
        unset($address[$index]);
        $user->address = json_encode(array_values($address));
        $user->save();
        return redirect('/customer/address');
    }


    public function updateAddress(Request $request,$index){
        $user = Auth::user();
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'phone' => 'required|numeric',
            'add_phone' => 'nullable|numeric',
            'delivery_address' => 'required|string',
            'add_info' => 'nullable|string',
            'zip' => 'required|string',
            'country' => 'required|string',
            'region' => 'required|string'
        ]);

        $address = json_decode($user->address, true);
        $address[$index] = $request->all();
        $user->address = json_encode($address);
        $user->save();

        toastr()->success('Address Updated');

        return redirect('/customer/address');
    }

    public function setDefaultAddress($index){
        $user = Auth::user();
        $address = json_decode($user->address, true);
        $this->switchPostion($address,0,$index);
        $user->address = json_encode($address);
        $user->save();
        return redirect('/customer/address');
    }

    protected function switchPostion(&$array,$a,$b){
        list($array[$a], $array[$b]) = array($array[$b],$array[$a]);
    }

    public function chat(Request $request){
        $user = Auth::user();
        $link = 'chat';

        $chats = Chat::where('chats.customer_id',$user->id)
                        ->join('users', 'users.id', '=', 'chats.vendor_id')
                        ->select('users.firstname', 'users.lastname','chats.vendor_id','chats.id')
                        ->get();
        $sessions = $chats->pluck('id')->toArray();

        if(empty($sessions)){
            $sessions = [];
            $request->session()->put(['activeChatSession'=>'']);
        }else{
            if(!$request->session()->has('activeChatSession')){
                $request->session()->put(['activeChatSession'=>$sessions[0]]);
            }
        }

        return view('customer.chat', compact('user','sessions','link'));
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

    public function getProfile(Request $request){
        $user = Auth::user();
        $tab = $request->tab ? $request->tab : "profile";
        $link = "profile";
        return view('customer.profile', compact('user', 'tab', 'link'));
    }

    public function savedItems(){
        try{

            $user = Auth::user();
            $savedItems = Wishlist::where("user_id", $user->id)->get();

            return view('customer.saved_items', compact('user', 'savedItems'));

        }catch(Exception $e){

        }
    }


}
