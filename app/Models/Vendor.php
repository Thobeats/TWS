<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ein',
        'proof_of_bus',
        'customer_review',
        'products',
        'products_offered',
        'created_at',
        'updated_at',
        'account_details',
        'verified',
        'verify_ein',
        'verify_business',
        'verify_customer_review',
        'business_address',
        'business_logo',
        'business_banner',
        'business_website',
        'facebook',
        'twitter',
        'instagram',
        'about',
        'bpone'
    ];

    public function business_logo(){
        return $this->business_logo != null ? url('storage/'. $this->business_logo)  : asset('images/logo-placeholder.png');
    }

    public function business_banner(){
        return $this->business_banner != null ? url('storage/'. $this->business_banner)  : "http://via.placeholder.com/640x360";
    }

    public function rating(){

    }

    public function reviews(){
        return $this->hasMany(VendorReview::class,'vendor_id', 'user_id')
                    ->join('users', 'users.id', '=', 'vendor_reviews.from')
                    ->get();
    }
}
