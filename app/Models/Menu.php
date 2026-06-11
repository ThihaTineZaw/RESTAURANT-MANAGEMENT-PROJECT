<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
        'category_id',
    ];

    function category()
    {
        return $this->belongsTo(Category::class);
    }

}
