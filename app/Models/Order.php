<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id', 'product_id', 'order_date', 'total_amount', 'status', 'payment_method'];
    protected $casts = [
        'total_amount' => 'decimal:2',
        'order_date' => 'datetime',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function itemOrder()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    public function canCancel()
    {
        return in_array($this->status, ['pending', 'paid']);
    }
}
