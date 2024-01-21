<?php

namespace App\Http\Livewire;

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
    public $variants;



    public function render()
    {
        return view('livewire.vendor-product');
    }
}
