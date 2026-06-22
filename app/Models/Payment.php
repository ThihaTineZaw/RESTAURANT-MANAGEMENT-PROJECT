<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_method',
        'total_price',
        'received_price',
        'change_price',
        'seller',
        'order_id',
    ];

    function order()
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
