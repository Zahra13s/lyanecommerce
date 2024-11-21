<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    //
    public function delete($id)
    {
        $cart = Cart::find($id);
        if ($cart) {
            $cart->delete();
            return response()->json(['message' => 'success']);
        }

        return response()->json(['message' => 'error'], 404);
    }
}
