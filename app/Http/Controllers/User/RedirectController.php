<?php

namespace App\Http\Controllers\User;

use App\Models\Blog;
use App\Models\Cart;
use App\Models\User;
use App\Models\color;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RedirectController extends Controller
{
    //
    //
    public function dashboard()
    {
        $products = Product::orderBy('created_at', 'desc')->limit(3)->get();
        $blogs = Blog::orderBy('created_at', 'desc')->limit(3)->get();
        return view("user.dashboard", compact('products', 'blogs'));
    }
    public function shopPage(Request $request)
    {
        $categories = Category::all(); // Get all categories
        $categoryId = $request->get('category'); // Get the selected category from query string

        if ($categoryId) {
            // Filter products by the selected category
            $products = Product::where('category_id', $categoryId)->get();
        } else {
            // If no category is selected, show all products
            $products = Product::all();
        }

        return view("user.shop", compact('products', 'categories'));
    }

    public function aboutUsPage()
    {
        $admins = User::whereIn("role", ["admin", "superadmin"])->get();

        return view("user.about", compact('admins'));
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

    public function contactUsPage()
    {
        return view("user.contact");
    }

    public function cartPage()
    {
        $cart_items = Cart::select('carts.*', 'products.name', 'products.image', "product_requests.width", "product_requests.length", "product_requests.color_id","colors.color")
            ->leftJoin("products", "products.id", "carts.product_id")
            ->leftJoin("product_requests", "product_requests.order_id",'carts.id')
            ->leftJoin("colors", "colors.id",'product_requests.color_id')
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

    public function productDetailsPage($id)
    {
        $product = Product::
        select('products.*','categories.category')
        ->leftJoin("categories","categories.id","products.category_id")

        ->where("products.id",$id)->first();
        $colors = color::get();
        return view('user.productDetails',compact('product','colors'));
    }
}
