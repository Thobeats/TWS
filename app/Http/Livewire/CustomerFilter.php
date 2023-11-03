<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CustomerFilter extends Component
{
    public $filterTag;
    public $customerCount;


    public function mount(){
        $this->filterTag = 'Today';
        $user= Auth::user();
        //Total Sales
        $currentDate = Carbon::now();

        $this->customerCount = Order::where('vendor_id', $user->id)
                                    ->whereMonth('created_at', $currentDate->toDateString())
                                    ->count();
    }

    public function customerFilter($filterType)
    {
        $user= Auth::user();
        //Total Sales
        $currentDate = Carbon::now();

        if($filterType == 'today'){
            $this->customerCount = Order::where('vendor_id', $user->id)
                            ->whereDate('created_at', $currentDate->toDateString())
                            ->count();
            $this->filterTag = ucfirst($filterType);
        }

        if($filterType == 'month'){
            $this->customerCount = Order::where('vendor_id', $user->id)
                            ->whereMonth('created_at', $currentDate->month)
                            ->count();
            $this->filterTag = "This " . ucfirst($filterType);
        }

        if($filterType == 'year'){
            $this->customerCount = Order::where('vendor_id', $user->id)
                            ->whereYear('created_at', $currentDate->year)
                            ->count();
            $this->filterTag = "This " .ucfirst($filterType);
        }
    }


    public function render()
    {
        return view('livewire.customer-filter');
    }
}
