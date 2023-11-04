<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardFilter extends Component
{
    public $salesCount;
    public $salesTag;
    public $revenueTag;
    public $revenue;

    public function mount(){
        $user= Auth::user();
        //Total Sales
        $currentDate = Carbon::now();

        $this->revenueTag = 'Today';
        $this->salesTag = 'Today';
        $this->revenue = Order::where('vendor_id', $user->id)
                        ->whereDate('created_at', $currentDate->toDateString())
                        ->select('total_price')
                        ->sum('total_price');

        $this->salesCount = Order::where('vendor_id', $user->id)
                        ->whereDate('created_at', $currentDate->toDateString())
                        ->count();
    }


    public function filterSales($filterType)
    {
        $user= Auth::user();
        //Total Sales
        $currentDate = Carbon::now();

        if($filterType == 'today'){
            $set_date =$currentDate->toDateString();
            $query = Order::where('vendor_id', $user->id)
                            ->whereDate('created_at',$set_date);
            $this->salesTag = ucfirst($filterType);

        }

        if($filterType == 'month'){
            $set_date = $currentDate->month;
            $query = Order::where('vendor_id', $user->id)
                            ->whereMonth('created_at',$set_date);
            $this->salesTag = "This " . ucfirst($filterType);
        }

        if($filterType == 'year'){
            $set_date = $currentDate->year;
            $query = Order::where('vendor_id', $user->id)
                            ->whereYear('created_at',$set_date);
            $this->salesTag = "This " .ucfirst($filterType);
        }

        $this->salesCount = $query->select('order_details->quantity')
                            ->sum('order_details->quantity');


    }

    public function revenueFilter($filterType){
        $user= Auth::user();
        //Total Sales
        $currentDate = Carbon::now();

        if($filterType == 'today'){
            $this->revenue = Order::where('vendor_id', $user->id)
                            ->whereDate('created_at', $currentDate->toDateString())
                            ->select('total_price')
                            ->sum('total_price');
            $this->revenueTag = ucfirst($filterType);
        }

        if($filterType == 'month'){
            $this->revenue = Order::where('vendor_id', $user->id)
                            ->whereMonth('created_at', $currentDate->month)
                            ->select('total_price')
                            ->sum('total_price');
            $this->revenueTag = "This " . ucfirst($filterType);
        }

        if($filterType == 'year'){
            $this->revenue = Order::where('vendor_id', $user->id)
                            ->whereYear('created_at', $currentDate->year)
                            ->select('total_price')
                            ->sum('total_price');
            $this->revenueTag = "This " . ucfirst($filterType);
        }
    }

    public function render()
    {
        return view('livewire.dashboard-filter');
    }
}
