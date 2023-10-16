<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserType::insert([[
            'name' => "Customer",
            'description' => "People that buy on the platform",
            'slug' => "customer",
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'name' => "Vendor",
            'description' => "People that sell on the platform",
            'slug' => "vendor",
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'name' => "Admin",
            'description' => "People that control the platform",
            'slug' => "admin",
            'created_at' => now(),
            'updated_at' => now()
        ]]);
    }
}
