<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Order;
use App\Models\Vendor;
use Livewire\Component;

class VendorSubMenu extends Component
{

    public $vendors;
    public $vendor_of_the_week;
    public $new_vendors;
    public $searchVendors;
    public $votw;

    public function mount(){
        $this->topVendors();
        $this->newVendors();
        $this->vendorOfTheWeek();
    }

    public function topVendors(){
        $this->vendors = Vendor::where('users.account_status', 0)
                                ->join('users','users.id','=','vendors.user_id')
                                ->leftJoin('orders','orders.vendor_id','=','vendors.user_id')
                                ->selectRaw("count(orders.vendor_id) as cnt, users.business_name, users.profile, users.id")
                                ->groupBy('users.id')
                                ->orderBy('cnt', 'DESC')
                                ->limit(2)
                                ->get();

    }

    public function newVendors(){
        $this->new_vendors = User::where(['users.role' => 2, 'users.account_status' => 0, 'vendors.verified' => 1])
                                    ->join('vendors','vendors.user_id','=','users.id')
                                    ->select('users.business_name','users.id')
                                    ->orderBy('vendors.created_at', 'DESC')
                                    ->limit(10)
                                    ->get();
    }

    public function vendorOfTheWeek(){
        // $this->votw = Order::whereBetween('orders.created_at', [now()->startOfWeek(), now()->endOfWeek()])
        //                             ->join('users','users.id','=','orders.vendor_id')
        //                             ->selectRaw("count(orders.id) as orders, orders.vendor_id, users.profile, users.business_name")
        //                             ->groupby('vendor_id')
        //                             ->orderby('vendor_id','DESC')
        //                             ->first();

        $this->votw = Vendor::where('users.account_status', 0)
                                ->join('users','users.id','=','vendors.user_id')
                                ->leftJoin('orders','orders.vendor_id','=','vendors.user_id')
                                ->first();
    }

    public function render()
    {
        return view('livewire.vendor-sub-menu');
    }
}
