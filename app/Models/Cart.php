<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['customer_id'];
    public function customer() {
        return $this->belongsTo(Customer::class);
    }
    public function itemCart() {
        return $this->hasMany(CartItem::class);
    }
    public function getTotalAttribute() {
        return $this->items->sum('quantity');
    }
    public function cleanItem() {
        return $this->item()->delete();
    }
}
