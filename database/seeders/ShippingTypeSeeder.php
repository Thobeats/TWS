<?php

namespace Database\Seeders;

use App\Models\ShippingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShippingType::insert([[
            'name' => "Local",
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'name' => "International",
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'name' => "Free",
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]]);
    }
}
