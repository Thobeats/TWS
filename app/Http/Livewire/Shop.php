<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class Shop extends Component
{

    public $categories;
    public $tags;
    public $products;
    public $sort;
    public $price;
    public $color;
    public array $cats = [];

    public function mount(){
        $this->categories();
        $this->products();
    }


    public function categories(){
        $this->categories = Category::where('status',1)->get();
    }

    public function productsByCategory($id){
        if(in_array($id,$this->cats)){
            unset($this->cats[array_search($id,$this->cats)]);
            array_values($this->cats);
        }else{
            $this->cats[] = $id;
        }

        $this->products();
    }

    public function products(){
        $query = Product::where('publish_status',1);


        if(count($this->cats) > 0){
            $QC = $this->cats;
            $query->where(function(Builder $query)use($QC){
                foreach($QC as $option){
                    $query->orWhereJsonContains('category_id',"$option");
                }
            });
        }

        $this->products = $query->limit(10)->get();
    }

    public function render()
    {
        return view('livewire.shop');
    }
}
