<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceConfirmed extends Model
{
    //
    protected $fillable = [
        "order_id", "price"
    ];
}
