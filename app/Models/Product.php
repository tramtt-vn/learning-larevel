<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'description', 'price', 'image', 'stock'];
    protected $casts = [
        'price'=> 'decimal:2',
    ];
    public function isInStock() {
        return $this->stock > 0;
    }
    public function cartItems() {
        return $this->hasMany(CartItem::class);
    }
    public function OrderItem() {
        return $this->hasMany(OrderItem::class);
    }
}

