<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class Shop extends Component
{

    public $tag;
    public $products;
    public $sort = 1;
    public $price = 1;
    public $productCount;
    public $limit = 10;
    public $sortBy;
    public array $cats = [];
    protected $listeners = ['sortBy' => 'sortBy', 'productsByCategory' => 'productsByCategory', 'priceFilter' => 'priceFilter', 'tagFilter' => 'tagFilter'];

    public function mount(){
        $this->products($this->limit);
    }

    public function productsByCategory($id){
        if(in_array($id,$this->cats)){
            unset($this->cats[array_search($id,$this->cats)]);
            array_values($this->cats);
        }else{
            $this->cats[] = $id;
        }

        $this->products($this->limit);
    }

    public function products($limit, $sort = 1, $price = 1, $tag = 1){
        DB::enableQueryLog();
        $this->sort = $sort;
        $this->price = $price;
        $query = Product::where('products.publish_status',1)
                         ->where('users.account_status', 1)
                         ->join('users', 'users.id', '=', 'products.vendor_id')
                         ->leftjoin('orders', 'orders.product_id', '=', 'products.id');

        if(count($this->cats) > 0){
            $QC = $this->cats;
            $query->where(function(Builder $query)use($QC){
                foreach($QC as $option){
                    $query->orWhereJsonContains('products.category_id',"$option");
                }
            });
        }

        //Price
        if ($price == 2){
            $query->where('products.price', '<', 50);
        }elseif ($price == 3){
            $query->whereBetween('products.price', [50, 100]);
        }elseif ($price == 4) {
            $query->whereBetween('products.price', [100, 150]);
        }elseif ($price == 5) {
            $query->whereBetween('products.price', [150, 200]);
        }elseif ($price == 6) {
            $query->where('products.price', '>', 200);
        }else{
            $query->where('products.price', '>', 1);
        }

        //Tags
        if ($tag != 1){
            $query->WhereJsonContains('products.tags',"$tag");
        }

        //Sort By
        if ($sort == 2){
            $query->select('products.*', DB::raw('count(orders.product_id) as cnt'))
                  ->groupBy('products.id')
                  ->orderBy('cnt', 'asc');
        }elseif ($sort == 3){
            $query->select('products.*')->latest();
        }elseif ($sort == 4) {
            $query->select('products.*')->orderBy('products.price', 'asc');
        }elseif ($sort == 5) {
            $query->select('products.*')->orderBy('products.price', 'desc');
        }else{
            $query->select('products.*');
        }


        $this->products = $query->limit($limit)->get();
        //dd(DB::getQueryLog());
        $this->productCount = count($this->products);
        $this->limit += 10;
    }

    public function sortBy($sort){
        $this->products($this->limit,$sort);
    }

    public function priceFilter($price){
        $this->products($this->limit,$this->sort,$price);
    }

    public function tagFilter($tag){
        $this->products($this->limit,$this->sort,$this->price,$tag);
    }

    public function render()
    {
        return view('livewire.shop');
    }
}
