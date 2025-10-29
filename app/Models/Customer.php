<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'address', 'password'];
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
}
