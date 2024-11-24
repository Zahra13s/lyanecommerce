<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

    public function userUpdateProfile(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profile_images'), $filename);

            if ($user->image) {
                $oldImagePath = public_path('uploads/profile_images/' . $user->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $user->image = $filename;
        }

        $user->phone_no = $request->phone;
        $user->address = $request->address;

        $user->save();
        return back()->with('success', 'Profile updated successfully!');
    }
}
