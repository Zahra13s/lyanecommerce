<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\color;
use App\Models\Price;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{

    public function updateProfile(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_no' => 'nullable|string|max:15',
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

        // Debug phone_no and address before saving
        logger('Phone No: ' . $request->phone_no);
        logger('Address: ' . $request->address);

        $user->phone_no = $request->phone_no;
        $user->address = $request->address;

        $user->save();

        logger('User updated: ', $user->toArray());

        return back()->with('success', 'Profile updated successfully!');
    }

    public function updateRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:user,admin', // Ensure valid roles
        ]);

        $user = User::find($request->user_id);
        if ($user) {
            $user->role = $request->role;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Role updated successfully.']);
        } else {
            \Log::error('User not found for role update', ['user_id' => $request->user_id]);
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }
    }

    public function updatePrice(Request $request)
    {
        $price = Price::find($request->id);

        $price->update(["price" => $request->price]);
        return back();
    }

    public function updateCategory(Request $request)
    {
        $category = Category::find($request->id);

        $category->update(["category" => $request->category]);
        return back();
    }

    public function updateColor(Request $request)
    {
        $color = color::find($request->id);

        $color->update(["color" => $request->color]);
        return back();
    }

    public function updateProduct(Request $request)
    {
        $product = Product::find($request->product_id);

        if ($request->hasFile('image')) {
            $oldImagePath = public_path('products/' . $product->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $newFileName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('products'), $newFileName);
            $imagePath = $newFileName;
        } else {
            $imagePath = $product->image;
        }

        $product->update([
            "name" => $request->name,
            "image" => $imagePath,
            "category_id" => $request->category,
            "description" => $request->description,
        ]);

        return back();
    }

}
