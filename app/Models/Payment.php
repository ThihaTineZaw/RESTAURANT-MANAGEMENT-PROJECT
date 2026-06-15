<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    //
    protected $fillable = [
        'amount',
        'change',
        'payment_method',
        'payment_status',
    ];
}
