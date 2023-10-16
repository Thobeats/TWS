<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_name',
        'package_price',
        'stripe_reference',
        'details',
        'description',
        'status',
        'created_at',
        'updated_at'
    ];


    public function getStripeRef(){
        return json_decode($this->stripe_reference, true);
    }
}
