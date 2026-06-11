<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;

class Category extends Model
{
    //
    protected $fillable = ['name', 'created_at', 'updated_at'];

    function posts()
    {
        return $this->hasMany(Menu::class);
    }

}
