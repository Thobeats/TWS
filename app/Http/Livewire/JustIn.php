<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;

class JustIn extends Component
{
    public $categories;
    public $newProducts;
    public $today;
    public $last7days;
    protected $listeners = ['get_products' => 'getNewProducts'];

    public function mount(){
        $this->getCategories();
        $this->getNewProducts();
        $this->countNewProducts();
    }

    public function getCategories(){
        $this->categories = Category::where('parent_to_children.parent_id', 0)
                        ->join('parent_to_children','parent_to_children.category_id','=','categories.id')
                        ->get()
                        ->map(function($item){
                            $count = Product::whereJsonContains('products.category_id',"$item->id")
                                            ->whereBetween('products.created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                            ->where('users.account_status', 1)
                                            ->join('users', 'users.id', '=' , 'products.vendor_id')
                                            ->count();
                            return [
                                'id' => $item->id,
                                'name' => $item->name,
                                'product_count' => $count
                            ];
                        });
    }

    public function getNewProducts($id=null){
        if($id == null){
            $id = Category::first()->id;
        }
        $this->newProducts = Product::where('products.publish_status',1)
                                    ->whereJsonContains('products.category_id', "$id")
                                    ->whereBetween('products.created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                    ->where('users.account_status', 1)
                                    ->join('users', 'users.id', '=' , 'products.vendor_id')
                                    ->orderBy('products.created_at','DESC')
                                    ->limit(5)
                                    ->get();
    }

    public function countNewProducts(){
        $currentDate = Carbon::now();
        $sevenDaysAgo = Carbon::now()->subDays(7);
        $this->today = Product::where('products.publish_status', 1)
                                ->whereDate('products.created_at', $currentDate->toDateString())
                                ->where('users.account_status', 1)
                                ->join('users', 'users.id', '=' , 'products.vendor_id')
                                ->count();

        $this->last7days =  Product::where('products.publish_status', 1)
                                    ->whereBetween('products.created_at', [$sevenDaysAgo->toDateString(), $currentDate->toDateString()])
                                    ->where('users.account_status', 1)
                                    ->join('users', 'users.id', '=' , 'products.vendor_id')
                                    ->count();
    }

    public function render()
    {
        return view('livewire.just-in');
    }
}
