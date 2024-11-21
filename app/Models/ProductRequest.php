<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    //
    protected $fillable = [
        'order_id', 'width', 'length', 'color_id'
    ];
}
