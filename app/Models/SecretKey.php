<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecretKey extends Model
{
    use HasFactory;

    private $stripe_key;
    private $pk_key;

    public function __construct(){
        $this->stripe_key = env('STRIPE_SECRET');
         $this->pk_key = env('STRIPE_PUBLIC');
    }
    public function getKey(){
        return $this->pk_key;
    }

    public function getSecret(){
        return $this->stripe_key;
    }
}
