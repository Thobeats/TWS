<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentToChild extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'category_id',
        'parent_id',
        'created_at',
        'updated_at'
        ];
}
