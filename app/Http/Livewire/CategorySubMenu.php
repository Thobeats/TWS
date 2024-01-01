<?php

namespace App\Http\Livewire;

use App\Models\ParentToChild;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySubMenu extends Component
{
    public $sub_categories;
    public $categories;
    public $new_arrivals;
    public $active;
    public $hasChildren;
    public $sub_categories2;
    public $active2;
    public $col_lg = 'col-lg-10';
    public $url;


    protected $listeners = ['get_subcategories' => 'getSubCategories'];

    public function mount(){
        $this->categories = Category::where('parent_to_children.parent_id', 0)
                ->join('parent_to_children', 'parent_to_children.category_id', 'categories.id')
                ->select('categories.*')
                ->get();

        $firstCategory = $this->categories->first();

        $this->getSubCategories($firstCategory->id,1);
        $this->hasChildren = ParentToChild::select('parent_id')->get()->toArray();
        $this->sub_categories2 = [];
    }

    public function getSubCategories($category_id, $step){

        if($step == 1){
            $this->sub_categories = Category::where('parent_to_children.parent_id', $category_id)
                                ->join('parent_to_children', 'parent_to_children.category_id', 'categories.id')
                                ->select('categories.*')
                                ->get()
                                ->toArray();
            if (!empty($this->sub_categories)){
                $this->col_lg = 'col-lg-8';
            }
            $this->active = $category_id;

            $this->new_arrivals = Product::where('products.publish_status', 1)->whereJsonContains('products.category_id', "$category_id")
                                ->select('products.pics','products.name','products.id', 'products.price', 'products.vendor_id')
                                ->orderBy('id', 'DESC')
                                ->limit(3)
                                ->get();
            $this->sub_categories2 = [];
        }elseif($step == 2){
            $this->sub_categories2 = Category::where('parent_to_children.parent_id', $category_id)
                                ->join('parent_to_children', 'parent_to_children.category_id', 'categories.id')
                                ->select('categories.*')
                                ->get()->toArray();
            $this->active2 = $category_id;

            $this->new_arrivals = Product::where('products.publish_status', 1)->whereJsonContains('products.category_id', "$category_id")
                                ->select('products.pics','products.name','products.id', 'products.price', 'products.vendor_id')
                                ->orderBy('id', 'DESC')
                                ->limit(3)
                                ->get();

            if (!empty($this->sub_categories2)){
                $this->col_lg = 'col-lg-6';
            }
        }

        $this->url = "/shop?query=$category_id";

    }

    public function render()
    {
        return view('livewire.category-sub-menu');
    }
}
