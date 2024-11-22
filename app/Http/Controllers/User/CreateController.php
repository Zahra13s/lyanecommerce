<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Save;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favourite;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    public function addProductDetails(Request $request)
    {
        $validated = $request->validate([
            'width' => 'required',
            'length' => 'required',
            'color_id' => 'required',
        ]);

        // Create a cart entry for the product
        $cart = Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id, // Assuming you pass product_id in the request
            'price' => $request->price, // Assuming you pass product price in the request
            'qty' => 1,
            'sub_total' => $request->price, // Assuming price * qty
        ]);

        $cartId = $cart->id;

        // Create a product request with width, length, and color_id
        $createProductReq = ProductRequest::create([
            'order_id' => $cartId,  // Initially, set order_id to cart_id
            'width' => $request->width,
            'length' => $request->length,
            'color_id' => $request->color_id,
        ]);

        return view('user.cart');
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        $existingCartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existingCartItem) {
            // If item already exists in the cart, increase the quantity
            $existingCartItem->qty += 1;
            $existingCartItem->sub_total = $existingCartItem->qty * $product->price;
            $existingCartItem->save();
        } else {
            // Otherwise, create a new cart item
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
        $cartItems = DB::table('carts')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }

        $orderCode = Str::uuid();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('products'), $imageName);
            $imagePath = 'products/' . $imageName;
        }

        foreach ($cartItems as $item) {
            // Create an order for each cart item
            $order = Order::create([
                'user_id' => $userId,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'sub_total' => $item->sub_total,
                'price' => $item->price,
                'order_code' => $orderCode,
            ]);

            // Update the corresponding product request's order_id to the newly created order's id
            ProductRequest::where('order_id', $item->id)->update([
                'order_id' => $order->id,
            ]);
        }

        // Insert into the order_verified table
        DB::table('order_varifieds')->insert([
            'order_code' => $orderCode,
            'image' => $imagePath,
        ]);

        // Delete cart items after the order has been placed
        DB::table('carts')->where('user_id', $userId)->delete();

        return back()->with('success', 'Order placed successfully!');
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
