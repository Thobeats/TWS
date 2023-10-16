<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "image_name",
        "image_uniqID",
        "created_at",
        "updated_at"
    ];
}
