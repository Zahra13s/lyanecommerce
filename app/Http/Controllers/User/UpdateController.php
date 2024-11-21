<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    //

    public function update(Request $request)
    {
        foreach ($request->items as $item) {
            $cartItem = Cart::find($item['id']);
            $cartItem->qty = $item['quantity'];
            $cartItem->sub_total = $cartItem->price * $cartItem->qty;
            $cartItem->save();

        }
        return back();
    }
}
