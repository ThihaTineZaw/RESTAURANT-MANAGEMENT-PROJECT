<?php

namespace App\Models;

use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'table_number',
        'status',
        'total_price',
        'seller',
    ];

    function orderItems()
    {
        return $this->hasMany(OrderDetail::class);
    }

    function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
