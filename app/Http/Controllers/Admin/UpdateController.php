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
      //update
      public function updateRole(Request $request) {
        $user = User::find($request->user_id);

        if ($user) {
            $user->role = $request->role;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Role updated successfully.']);
        } else {
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
