<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'address', 'password','shipping_address','shipping_phone','notes'];
    protected $hidden = ['password'];
    protected $casts = [
        'password' => 'hashed',
    ];
    public function cart() {
        return $this->hasOne(Cart::class);
    }
    public function order() {
        return $this->hasOne(Order::class);
    }
    public function getOrCreateCart() {
        if(!$this->cart) {
            return $this->cart()->create();
        }
        return $this->cart();
    }
    public function getShippingAddressAttribute($value)
    {
        return $value ?? $this->address;
    }
    public function getShippingPhoneAttribute($value)
    {
        return $value ?? $this->phone;
    }
}
