<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            $imagePath = public_path('products/' . $product->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $product->delete();
        }

        return back()->with('success', 'Product deleted successfully!');
    }

}
