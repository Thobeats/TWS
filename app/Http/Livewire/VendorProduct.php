<?php

namespace App\Http\Livewire;

use App\Models\ProductVariant;
use Livewire\Component;

class VendorProduct extends Component
{
    public $productId;
    public $product;
    public $categoryTemp;
    public $tags;
    public $sections;
    public $product_tags;
    public $product_sections;
    public $productVariants;
    public $variantListings;



    public function mount(){
        $this->productId = $this->product->id;
        $this->loadVariants();
    }


    public function loadVariants()
    {
        $variants = ProductVariant::where("product_id", $this->product->id)->first()->toArray();
        if (count($variants) > 0) {
            $this->productVariants = json_decode($variants['variant'],true);
            $this->variantListings = json_decode($variants['variant_to_values'],true);
        }else{
            $this->productVariants = [];
            $this->variantListings = [];
        }

    }


    public function render()
    {
        return view('livewire.vendor-product');
    }
}
