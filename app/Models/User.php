<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'email',
        'password',
        'zip_code',
        'business_name',
        'address',
        'cert',
        'add_cert',
        'role',
        'gender',
        'account_status',
        'profile',
        'email',
        'email_verified',
        'created_at',
        'updated_at',
        'user_code',
        'country_code',
        'stripe_customer',
        'payment_method',
        'can_switch'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function fullname(){
        return $this->firstname . " " . $this->lastname;
    }

    public function address(){
        return isset(json_decode($this->address, true)[0]) ? json_decode($this->address, true)[0] : [
            "address" => "",
            "city" => "",
            "state" => ""
        ];
    }

    public function accountId(){
        $account = Vendor::where('user_id', $this->id)->first();
        $details = json_decode($account->account_details);

        return $details->id;
    }

    public function cartCount(){

    }

    public function cartItems(){

    }

    public function vendor(){
        return $this->hasOne(Vendor::class)->first();
    }

    public function profileImg(){
        return $this->profile != null ? url('storage/'. $this->profile)  : asset('images/blank.jpg');
    }
}
