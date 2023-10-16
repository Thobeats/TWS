<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class JustIn extends Component
{
    public $categories;
    public $newProducts;
    protected $listeners = ['get_products' => 'getNewProducts'];

    public function mount(){
        $this->getCategories();
        $this->getNewProducts();
    }

    public function getCategories(){
        $this->categories = Category::where('parent_to_children.parent_id', 0)
                        ->join('parent_to_children','parent_to_children.category_id','=','categories.id')
                        ->get()
                        ->map(function($item){
                            $count = Product::whereJsonContains('category_id',"$item->id")
                                            //->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
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
        $this->newProducts = Product::where('publish_status',1)
                                    ->whereJsonContains('category_id', "$id")
                                    //->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                                    ->orderBy('created_at','DESC')
                                    ->limit(5)
                                    ->get();
    }

    public function render()
    {
        return view('livewire.just-in');
    }
}
