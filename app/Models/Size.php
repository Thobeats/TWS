<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "size_code",
        "us_size",
        "eu_size",
        "uk_size",
        "created_at",
        "updated_at"
        ];
}
