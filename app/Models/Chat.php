<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;


    protected $fillable = [
        'vendor_id',
        'customer_id',
        'chat_message',
        'created_at',
        'updated_at',
        'vendor_read_status',
        'customer_read_status'
    ];
}
