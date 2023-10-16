<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_status')->insert([
            [
                "name" => 'Pending',
                "description" => "Order has not been attended to yet",
                "slug" => "pending",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => 'Delivered',
                "description" => "Order has been delivered to the customer",
                "slug" => "delivered",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name" => 'Canceled',
                "description" => "Order has not been canceled",
                "slug" => "canceled",
                "created_at" => now(),
                "updated_at" => now()
            ]
        ]);
    }
}
