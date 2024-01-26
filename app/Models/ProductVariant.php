<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_to_values',
        'created_at',
        'updated_at',
        'sessionId',
        'session_status',
        'vendor_id',
        'variant'
    ];
}
