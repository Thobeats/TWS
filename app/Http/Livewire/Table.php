<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class Table extends Component
{
    public $table;

    public function render()
    {
        return view('livewire.table');
    }
}
