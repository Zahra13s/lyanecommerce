<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable =[
        'cart_id', 'price', 'order_code','order_confirm'
    ];
}
