<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    //
    protected $fillable =[
        'comment_id', 'reply', 'admin_id'
    ];
}
