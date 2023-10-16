<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        "vendor_id",
        "order_number",
        "order_details",
        "total_price",
        "customer_id",
        "status",
        "reference_number",
        "created_at",
        "updated_at"
    ];
}
