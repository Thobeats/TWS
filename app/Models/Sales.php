<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'vendor_id',
        'customer_id',
        'sale_status',
        'created_at',
        'updated_at'
    ];
}
