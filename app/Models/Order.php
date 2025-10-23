<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id', 'product_id', 'order_date', 'total_amount', 'status', 'payment_method'];
}
