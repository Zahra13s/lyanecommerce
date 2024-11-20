<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable =[
        'user_id',
        'product_id',
        'price',
        'qty',
        'sub_total',
        'price',
        'order_code'
    ];
}
