<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'payment_intent',
        'transfer_group',
        'status',
        'order_details',
        'created_at',
        'updated_at'
    ];
}
