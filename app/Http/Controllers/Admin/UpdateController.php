<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Price;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateController extends Controller
{
    public function updateRole(Request $request) {
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


    public function updatePrice(Request $request){
        $price = Price::find($request->id);

        $price->update(["price" => $request->price]);
        return back();
    }

        public function updateCategory(Request $request){
        $category = Category::find($request->id);

        $category->update(["category" => $request->category]);
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
            "description" => $request->description
        ]);

        return back();
    }

}
