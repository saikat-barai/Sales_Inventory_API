<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'unit', 'img_url', 'user_id', 'category_id'
    ];

    function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
