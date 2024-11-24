<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Save;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Product;
// use Illuminate\Support\Facades\Request;
use App\Models\Category;
use App\Models\Favourite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OrderVarified;
use App\Models\ProductRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateController extends Controller
{
    public function addProductDetails(Request $request)
    {
        $validated = $request->validate([
            'width' => 'required',
            'length' => 'required',
            'color_id' => 'required',
        ]);

        $product = Product::findOrFail($request->product_id);
        $width = $request->width;
        $length = $request->length;
        $product_price = $product->price;
        $sqrfeet = ($width * $length) / 144;
        $price = ($sqrfeet * $product_price) + ($sqrfeet * 3500);

        $cart = Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'price' => $price,
            'qty' => 1,
            'sub_total' => $price,
        ]);

        ProductRequest::create([
            'order_id' => $cart->id,
            'width' => $request->width,
            'length' => $request->length,
            'color_id' => $request->color_id,
        ]);

        return back()->with('showRatingModal', true);
    }

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
        $cartItems = DB::table('carts')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }

        $orderCode = Str::uuid();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('order_varified'), $imageName);
            $imagePath = $imageName;
        }

        foreach ($cartItems as $item) {
            $order = Order::create([
                'user_id' => $userId,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'sub_total' => $item->sub_total,
                'price' => $item->price,
                'order_code' => $orderCode,
            ]);

            ProductRequest::where('order_id', $item->id)->update([
                'order_id' => $order->id,
            ]);
        }

        OrderVarified::create([
            'order_code' => $orderCode,
            'image' => $imagePath,
        ]);

        DB::table('carts')->where('user_id', $userId)->delete();
        $this->updateProductSalesCount($order->product_id, $order->qty);

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

        $existingFavourite = Favourite::where('item_id', $blogId)
            ->where('user_id', $userId)
            ->first();

        if (!$existingFavourite) {
            Favourite::create([
                'item_id' => $blogId,
                'user_id' => $userId,
            ]);
        }
        return back();
    }

    public function createSave(Request $request)
    {
        $userId = Auth::user()->id;
        $blogId = $request->blog_id;

        $existingSave = Save::where('blog_id', $blogId)
            ->where('user_id', $userId)
            ->first();

        if (!$existingSave) {
            Save::create([
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

    public function productRate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $userId = auth()->id();

        $existingRating = Rating::where('product_id', $request->product_id)
            ->where('user_id', $userId)
            ->first();

        if ($existingRating) {
            $existingRating->update([
                'rating' => $request->rating,
            ]);
        } else {
            Rating::create([
                'product_id' => $request->product_id,
                'user_id' => $userId,
                'rating' => $request->rating,
            ]);
        }

        return back()->with('success', 'Rating submitted successfully!');
    }

    public function sendContactForm(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required',
            'message' => 'required|string',
        ]);

        if ($this->isOnline()) {
            $email_data = [
                'recipient' => "lyancalligraphyanddecor@gmail.com",
                'fromEmail' => $request->email,
                'fromName' => $request->first_name . ' ' . $request->last_name,
                'subject' => $request->subject,
                'body' => $request->message
            ];

            Mail::send('email-template', $email_data, function ($message) use ($email_data) {
                $message->to($email_data['recipient'])
                        ->from($email_data['fromEmail'], $email_data['fromName'])
                        ->subject($email_data['subject']);
            });

            return redirect()->back()->with('success', 'Your message has been sent successfully!');
        } else {
            return redirect()->back()->with('error', 'Unable to send message, please check your connection.');
        }
    }

    public function isOnline($site = "https://youtube.com/")
    {
        return @fopen($site, "r") ? true : false;
    }

    public function updateProductSalesCount()
    {

        $productSales = Order::leftJoin('products', 'products.id', '=', 'orders.product_id')
            ->select('orders.product_id', DB::raw('SUM(orders.qty) as total_qty_sold'))
            ->groupBy('orders.product_id')
            ->get();

        foreach ($productSales as $sale) {

            Product::where('id', $sale->product_id)
                ->update(['sales_count' => $sale->total_qty_sold]);
        }
        $updatedProducts = Product::all();
        return $updatedProducts;
    }

}
