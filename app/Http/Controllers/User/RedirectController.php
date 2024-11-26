<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Cart;
use App\Models\Category;
use App\Models\color;
use App\Models\Comment;
use App\Models\Order;
use App\Models\OrderVarified;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RedirectController extends Controller
{
    //
    public function dashboard()
    {
        $products = Product::orderBy('created_at', 'desc')->limit(3)->get();
        $blogs = Blog::orderBy('created_at', 'desc')->limit(3)->get();
        $top3Sales = Product::orderBy("sales_count", "desc")->limit(3)->get();
        return view("user.dashboard", compact('products', 'blogs','top3Sales'));
    }

    public function shopPage(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->get('category');

        if ($categoryId) {
            $products = Product::where('category_id', $categoryId)->paginate(8);
        } else {
            $products = Product::paginate(8);
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
        $comments = Comment::select(
            "comments.*",
            "users.name as user_name",
            "replies.reply",
            "admin_users.name as admin_name"
        )
            ->leftJoin("users", "users.id", "comments.user_id") // For users who commented
            ->leftJoin("replies", "replies.comment_id", "comments.id")
            ->leftJoin("users as admin_users", "admin_users.id", "replies.admin_id") // For admins replying
            ->where("blog_id", $id)
            ->get();

        return view('user.blogDetails', compact('blog', 'comments'));
    }

    public function contactUsPage()
    {
        return view("user.contact");
    }

    public function cartPage()
    {
        $cart_items = Cart::select('carts.*', 'products.name', 'products.image', "product_requests.width", "product_requests.length", "product_requests.color_id", "colors.color")
            ->leftJoin("products", "products.id", "carts.product_id")
            ->leftJoin("product_requests", "product_requests.order_id", 'carts.id')
            ->leftJoin("colors", "colors.id", 'product_requests.color_id')
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
            select('products.*', 'categories.category')
            ->leftJoin("categories", "categories.id", "products.category_id")
            ->where("products.id", $id)->first();
        if (!$product) {
            return redirect()->route('shopPage')->with('error', 'Product not found.');
        }
        $colors = color::get();
        return view('user.productDetails', compact('product', 'colors'));
    }

    public function profilePage()
    {
        return view('user.profile');
    }

    public function orderHistoryPage()
    {
        $orders = OrderVarified::select("order_varifieds.order_code","orders.user_id")
        ->Join("orders","orders.order_code","order_varifieds.order_code")
            ->where("orders.user_id", Auth::user()->id)
             ->get();
        return view('user.history.orderHistory', compact('orders'));
    }

    public function ratingHistoryPage()
    {
        $ratings = Rating::select('ratings.*', 'products.name', 'products.image', 'categories.category')
            ->leftJoin("products", "ratings.product_id", "products.id")
            ->leftJoin('categories', "products.category_id", "categories.id")
            ->where("ratings.user_id", Auth::user()->id)
            ->get();
        return view('user.history.ratingHistory', compact('ratings'));
    }

    public function contactHistoryPage()
    {
        return view('user.history.contactHistory');
    }

    public function orderHistoryDetails($order_code)
    {
        $orders = Order::select("orders.*", "order_varifieds.checked", "products.name", "products.image", "categories.category")
            ->where("orders.user_id", Auth::user()->id)
            ->where('orders.order_code', $order_code)
            ->leftJoin("order_varifieds", "order_varifieds.order_code", "orders.order_code")
            ->leftJoin('products', 'orders.product_id', "products.id")
            ->leftJoin("categories", "categories.id", "products.category_id")
            ->get();
        return view('user.history.orderHistoryDetails', compact('orders', 'order_code'));
    }

    public function userProfilePage(Request $request)
    {
        $user = auth()->user();

        $blogFavorites = DB::table('favourites')->select("favourites.*","blogs.*","blogs.id as blog_id")
        -> leftJoin("blogs", "blogs.id", "favourites.item_id")->where('user_id', $user->id)->get();
        $blogSavedItems = DB::table('saves')->select("blogs.*","blogs.*","blogs.id as blog_id")
        -> leftJoin("blogs", "blogs.id", "saves.blog_id")->where('user_id', $user->id)->get();

        $activeTab = $request->query('tab', 'favorites');

        return view('user.profile', compact('user', 'blogFavorites', 'blogSavedItems', 'activeTab'));
    }

}
