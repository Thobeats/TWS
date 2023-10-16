<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        "image",
        "slug",
        "tags",
        "title",
        "subtitle",
        "status",
        "created_at",
        "updated_at"
    ];

    public function tags(){
        $tags = Tag::whereIn('id', json_decode($this->tags,true))->select('name')->get()->toArray();
        return array_column($tags,'name');
    }
}
