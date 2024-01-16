<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VendorProduct extends Component
{
    public $productId;
    public $variants;

    public function render()
    {
        return view('livewire.vendor-product');
    }
}
