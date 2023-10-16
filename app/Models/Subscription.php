<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable=[
        'vendor_id',
        'package_id',
        'status',
        'created_at',
        'updated_at',
        'stripe_reference',
        'from',
        'end_date',
        'validity'
    ];
}
