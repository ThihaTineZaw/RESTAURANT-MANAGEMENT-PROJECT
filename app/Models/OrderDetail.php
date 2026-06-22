<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'menu_id',
        'seller',
        'quantity',
    ];
    
    function order()
    {
        return $this->belongsTo(Order::class);
    }

    function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
