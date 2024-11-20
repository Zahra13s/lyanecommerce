<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Cart;
use App\Models\Comment;
use App\Models\Favourite;
use App\Models\Order;
use App\Models\OrderVarified;
use App\Models\Product;
use App\Models\Save;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    //read
    public function dashboard()
    {
        $products = Product::limit(3)->get();
        $blogs = Blog::limit(3)->get();
        return view("user.dashboard", compact('products', 'blogs'));
    }

    public function shopPage()
    {
        $products = Product::limit(3)->get();
        return view("user.shop", compact('products'));
    }

    public function aboutUsPage()
    {
        return view("user.about");
    }

    public function blogPage()
    {
        $blogs = Blog::get();
        return view("user.blog", compact('blogs'));
    }

    public function blogDetails($id)
    {
        $blog = Blog::find($id);
        $comments = Comment::select("comments.*", "users.name")
            ->leftJoin("users", "users.id", "comments.user_id")
            ->where("blog_id", $id)->get();
        return view('user.blogDetails', compact('blog', 'comments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate unique order code
        $orderCode = Str::random(10);

        // Save order details
        $order = Order::create([
            'cart_code' => $request->cart_code,
            'price' => $request->total_price,
            'order_code' => $orderCode,
        ]);

        // Save image with unique name
        $image = $request->file('image');
        $uniqueImageName = $orderCode . '_' . time() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('Paymentverified', $uniqueImageName, 'public');

        // Save image details to OrderVarified table
        OrderVarified::create([
            'order_code' => $orderCode,
            'image' => $imagePath,
        ]);

        return ('success' . 'Order placed successfully!');
    }

    public function addFavourite(Request $request)
    {
        $userId = Auth::user()->id;
        $blogId = $request->blog_id;

        // Check if the favorite already exists to prevent duplicates
        $existingFavourite = Favourite::where('blog_id', $blogId)
            ->where('user_id', $userId)
            ->first();

        if (!$existingFavourite) {
            // Add new favourite if not already in the database
            Favourite::create([
                'blog_id' => $blogId,
                'user_id' => $userId,
            ]);
        }

        return back();
    }

    public function addSave(Request $request)
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

    public function contactUsPage()
    {
        return view("user.contact");
    }

    public function cartPage()
    {
        $cart_items = Cart::select('carts.*', 'products.name', 'products.image')
            ->leftJoin("products", "products.id", "carts.product_id")
            ->where("carts.user_id", auth()->user()->id)
            ->get();
        // dd($cart_items);
        return view("user.cart", compact("cart_items"));
    }

    public function reciepePage()
    {
        $cart_items = Cart::select('carts.*', 'products.name', 'products.image')
            ->leftJoin("products", "products.id", "carts.product_id")
            ->where("carts.user_id", auth()->user()->id)
            ->get();
        return view('user.reciept', compact('cart_items'));
    }

    //create
    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        // Check if the user already has items in the cart
        $existingCart = Cart::where('user_id', auth()->id())->first();

        // Use the existing cart code or generate a new one if the cart is empty
        $cartCode = $existingCart ? $existingCart->cart_code : 'Lyan' . Str::random(8);

        Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'price' => $product->price,
            'qty' => 1,
            'sub_total' => $product->price * 1,
            'cart_code' => $cartCode,
        ]);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function addComment(Request $request)
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

    //update

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

    public function delete($id)
    {
        // Remove dd($id) after testing
        $cart = Cart::find($id);
        if ($cart) {
            $cart->delete();
            return response()->json(['message' => 'success']);
        }

        return response()->json(['message' => 'error'], 404);
    }

}
