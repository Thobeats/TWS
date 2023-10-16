<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'product_id',
        'comment',
        'rating',
        'created_at',
        'updated_at',
    ];
}
