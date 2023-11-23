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
    public $vendorCount;
    public $customerCount;
    public $vendorTag;
    public $customerTag;
    public $productTag;
    public $packageCount;
    public $productCount;

    public function mount(){
        $this->vendorCount(0);
        $this->customerCount(0);
        $this->packageCount();
        $this->productCount(0);
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

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
