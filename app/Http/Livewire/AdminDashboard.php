<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $vendors;
    public $vendorCount;
    public $customerCount;
    public $vendorTag;
    public $customerTag;
    public $productTag;
    public $customers;
    public $packageCount;
    public $productCount;
    public $topVendors;
    public $topSelling;
    public $topSellingTag;

    public function mount(){
        $this->vendorCount(0);
        $this->customerCount(0);
        $this->packageCount();
        $this->productCount(0);
        $this->recentVendors();
        $this->recentCustomers();
        $this->topVendors();
        $this->topSelling();
    }

    public function vendorCount($filter = 0, $tag = 'All'){
        $query = Vendor::join('users', 'users.id', '=', 'vendors.user_id');
        $time = Carbon::now();
        $this->vendorTag = $tag;

        if ($filter == 1)
        {
            $query = $query->whereDate('vendors.created_at', $time->toDateString());
        }

        if ($filter == 2)
        {
            $query = $query->whereMonth('vendors.created_at', $time->month);
        }

        if ($filter == 3)
        {
            $query = $query->whereYear('vendors.created_at', $time->year);
        }

        if ($filter == 4)
        {
            $query = $query->where('users.account_status', 1);
        }

        if ($filter == 5)
        {
            $query = $query->where('users.account_status', 0);
        }

        $this->vendorCount = $query->count();
    }

    public function customerCount($filter = 0, $tag = 'All'){
        $query = User::where('role', 1);
        $time = Carbon::now();
        $this->customerTag = $tag;

        if ($filter == 1)
        {
            $query = $query->whereDate('created_at', $time->toDateString());
        }

        if ($filter == 2)
        {
            $query = $query->whereMonth('created_at', $time->month);
        }

        if ($filter == 3)
        {
            $query = $query->whereYear('created_at', $time->year);
        }

        if ($filter == 4)
        {
            $query = $query->where('account_status', 1);
        }

        if ($filter == 5)
        {
            $query = $query->where('account_status', 0);
        }

        $this->customerCount = $query->count();
    }

    public function productCount($filter = 0, $tag = 'All'){
        $query = new Product;
        $time = Carbon::now();
        $this->productTag = $tag;

        if ($filter == 1)
        {
            $query = $query->whereDate('created_at', $time->toDateString());
        }

        if ($filter == 2)
        {
            $query = $query->whereMonth('created_at', $time->month);
        }

        if ($filter == 3)
        {
            $query = $query->whereYear('created_at', $time->year);
        }

        if ($filter == 4)
        {
            $query = $query->where('publish_status', 1);
        }

        if ($filter == 5)
        {
            $query = $query->where('publish_status', 0);
        }

        $this->productCount = $query->count();
    }

    public function packageCount(){
        $this->packageCount = Package::where('status', 1)->count();
    }

    public function recentVendors(){
        $this->vendors = Vendor::join('users', 'users.id', '=', 'vendors.user_id')
                                ->select('users.firstname', 'users.lastname', 'users.email', 'users.business_name', 'vendors.verified', 'users.created_at')
                                ->limit(10)
                                ->get();
    }

    public function recentCustomers(){
        $this->customers = User::where('role', 1)
                                ->select('users.firstname', 'users.lastname', 'users.email', 'users.business_name', 'users.account_status as verified', 'users.created_at')
                                ->limit(10)
                                ->get();
    }

    public function topVendors(){
        $this->topVendors = Vendor::where('users.account_status', 1)
                                    ->join('users','users.id','=','vendors.user_id')
                                    ->leftJoin('orders','orders.vendor_id','=','vendors.user_id')
                                    ->selectRaw("count(orders.vendor_id) as cnt, users.business_name, users.profile, users.id, sum(orders.total_price) as revenue")
                                    ->groupBy('users.id')
                                    ->having('cnt', '>', 0)
                                    ->orderBy('cnt', 'DESC')
                                    ->limit(5)
                                    ->get();
    }

    public function topSelling(){
        $query = Product::where('products.publish_status', 1)->leftJoin('orders','orders.product_id','=','products.id');
        // $time = Carbon::now();
        // $this->topSellingTag = $tag;

        // if ($filter == 0)
        // {
        //     $query = $query->whereDate('orders.created_at', $time->toDateString());
        // }

        // if ($filter == 1)
        // {
        //     $query = $query->whereMonth('orders.created_at', $time->month);
        // }

        // if ($filter == 2)
        // {
        //     $query = $query->whereYear('orders.created_at', $time->year);
        // }

        $this->topSelling = $query->selectRaw("count(orders.product_id) as sold, products.name,products.price, products.pics, sum(orders.total_price) as revenue")
                                    ->groupBy('products.id')
                                    ->having('sold', '>', 0)
                                    ->orderBy('sold', 'DESC')
                                    ->limit(5)
                                    ->get();
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
