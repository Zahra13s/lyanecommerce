<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Save;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favourite;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CreateController extends Controller
{
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        $existingCartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existingCartItem) {
            $existingCartItem->qty += 1;
            $existingCartItem->sub_total = $existingCartItem->qty * $product->price;
            $existingCartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'price' => $product->price,
                'qty' => 1,
                'sub_total' => $product->price,
            ]);
        }
        return back()->with('success', 'Product added to cart successfully!');
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userId = $request->user()->id;

        // Fetch cart items
        $cartItems = DB::table('carts')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        // Generate unique order code
        $orderCode = Str::uuid();

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('order_varified', 'public'); // Save image in 'storage/app/public/order_varified'
        }

        // Insert order details
        foreach ($cartItems as $item) {
            DB::table('orders')->insert([
                'user_id'    => $userId,
                'product_id' => $item->product_id,
                'qty'        => $item->qty,
                'sub_total'  => $item->sub_total,
                'price'      => $item->price,
                'order_code' => $orderCode,
            ]);
        }

        // Insert verification details
        DB::table('order_varifieds')->insert([
            'order_code' => $orderCode,
            'image'      => $imagePath, // Save relative path
        ]);

        // Clear user's cart
        DB::table('carts')->where('user_id', $userId)->delete();

        return response()->json([
            'message' => 'Order placed successfully',
            'order_code' => $orderCode,
            'image_url' => asset('storage/' . $imagePath), // Return full URL to image
        ]);
    }



    public function createComment(Request $request)
    {
        $validated = $request->validate([
            "comment" => 'required',
        ]);
        Comment::create([
            "blog_id" => $request->blog_id,
            "user_id" => $request->user_id,
            "comment" => $request->comment,
        ]);
        return back();
    }

    public function createFavourite(Request $request)
    {
        $userId = Auth::user()->id;
        $blogId = $request->blog_id;

        // Check if the favorite already exists to prevent duplicates
        $existingFavourite = Favourite::where('blog_id', $blogId)
            ->where('user_id', $userId)
            ->first();

        if (!$existingFavourite) {
            // create new favourite if not already in the database
            Favourite::create([
                'blog_id' => $blogId,
                'user_id' => $userId,
            ]);
        }

        return back();
    }

    public function createSave(Request $request)
    {
        $userId = Auth::user()->id;
        $blogId = $request->blog_id;

        $existingFavourite = Save::where('blog_id', $blogId)
            ->where('user_id', $userId)
            ->first();

        if (!$existingSave) {
            Favourite::create([
                'blog_id' => $blogId,
                'user_id' => $userId,
            ]);
        }

        return back();
    }

    public function filterProducts(Request $request)
{
    $categories = Category::all();
    $categoryId = $request->get('category');

    if ($categoryId) {
        $products = Product::where('category_id', $categoryId)->get();
    } else {
        $products = Product::all();
    }

    return view('user.shop', compact('categories', 'products'));
}


}
