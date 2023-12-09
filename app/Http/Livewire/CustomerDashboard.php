<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Order;
use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class CustomerDashboard extends Component
{
    public $savedItems;
    public $orderTag;
    public $orders;
    public $recentOrders;

    public function mount(){
        $user = Auth::user();

        // Saved Items
        $squery = Wishlist::where('user_id', $user->id);
        $this->savedItems = $squery->count();


        //Orders
        $this->orderTag = 'all';
        $this->orders = Order::where('customer_id', $user->id)->count();


        // Recent Orders
        $this->recentOrders = Order::where("orders.customer_id", $user->id)
                                ->join('users', 'users.id', '=', 'orders.vendor_id')
                                ->join('products', 'products.id', '=', 'orders.order_details->product_id')
                                ->join('order_status', 'order_status.id', '=', 'orders.status')
                                ->select('orders.id', 'products.pics','orders.total_price',
                                        'orders.status','users.id as user_id', 'users.firstname',
                                        'users.lastname','orders.order_details->num_of_product as num_products',
                                        'order_status.name as status',
                                        'orders.status as status_id',
                                        'orders.order_details->product_id as prodID')
                                ->limit(5)
                                ->orderBy('orders.created_at', 'desc')
                                ->get()
                                ->toArray();
    }

    public function filterOrders($orderType){
        $user = Auth::user();
        $currentDate = Carbon::now();

        if($orderType == 'all'){
            $this->orderTag = 'all';
            $this->orders = Order::where('customer_id', $user->id)->count();
        }

        if($orderType == 'this month'){
            $this->orderTag = date('M');
            $this->orders = Order::where('customer_id', $user->id)
                                    ->whereMonth('created_at',$currentDate->month)->count();
        }

        if($orderType == 'today'){
            $this->orderTag = date('D');
            $this->orders = Order::where('customer_id', $user->id)
                                    ->whereDate('created_at',$currentDate->toDateString())->count();
        }
    }



    public function render()
    {
        return view('livewire.customer-dashboard');
    }
}
