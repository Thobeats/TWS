<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'name' => $row[0],
            'vendor_id' => auth()->user()->id,
            'price' => $row[1],
            'description' => $row[2],
            'shipping_fee' => 10,
            'tags' => json_encode(["3"]),
            'publish_status' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
