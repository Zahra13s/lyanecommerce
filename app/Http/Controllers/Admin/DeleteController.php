<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Product;

class DeleteController extends Controller
{
    // delete products
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

    //delete blogs
    public function deleteBlog($id)
    {
        $blog = Blog::findOrFail($id);

        if ($blog->image) {
            $images = json_decode($blog->image);
            foreach ($images as $image) {
                $filePath = public_path("blogs/{$image}");
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $blog->delete();

        return redirect()->back()->with('success', 'Blog deleted successfully.');
    }

}
