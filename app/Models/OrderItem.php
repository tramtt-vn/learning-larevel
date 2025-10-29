<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];
    public $timestamps = false; // Vì schema không có timestamps
    protected $casts = [
        'price' => 'decimal:2',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
