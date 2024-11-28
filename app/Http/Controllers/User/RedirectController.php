<?php

namespace App\Http\Controllers\User;

use App\Models\Blog;
use App\Models\Cart;
use App\Models\User;
use App\Models\color;
use App\Models\Order;
use App\Models\Price;
use App\Models\Rating;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\OrderVarified;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    //user dashboard
    public function dashboard()
    {
        $products = Product::orderBy('created_at', 'desc')->limit(3)->get();
        $blogs = Blog::orderBy('created_at', 'desc')->limit(3)->get();
        $top3Sales = Product::orderBy("sales_count", "desc")->limit(3)->get();
        $price = Price::orderBy("price","asc")->first();
        return view("user.dashboard", compact('products', 'blogs','top3Sales','price'));
    }

    //redirect shop page
    public function shopPage(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->get('category');
        $top3Sales = Product::orderBy("sales_count", "desc")->limit(3)->get();
        $price = Price::orderBy("price","asc")->first();
        if ($categoryId) {
            $products = Product::where('category_id', $categoryId)->paginate(8);
        } else {
            $products = Product::paginate(8);
        }

        return view("user.shop", compact('products', 'categories', 'top3Sales',"price"));
    }

    //about us page
    public function aboutUsPage()
    {
        $admins = User::whereIn("role", ["admin", "superadmin"])->get();

        return view("user.about", compact('admins'));
    }

    //blog page
    public function blogPage()
    {
        $blogs = Blog::get();
        return view("user.blog", compact('blogs'));
    }

    //blog details
    public function blogDetails($id)
    {
        $blog = Blog::find($id);
        $comments = Comment::select(
            "comments.*",
            "users.name as user_name",
            "replies.reply",
            "admin_users.name as admin_name"
        )
            ->leftJoin("users", "users.id", "comments.user_id")
            ->leftJoin("replies", "replies.comment_id", "comments.id")
            ->leftJoin("users as admin_users", "admin_users.id", "replies.admin_id")
            ->where("blog_id", $id)
            ->get();

        return view('user.blogDetails', compact('blog', 'comments'));
    }

    //contact us page
    public function contactUsPage()
    {
        return view("user.contact");
    }

    //cart page
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

    //reciepe page
    public function reciepePage()
    {
        $cart_items = Cart::select('carts.*', 'products.name', 'products.image')
            ->leftJoin("products", "products.id", "carts.product_id")
            ->where("carts.user_id", auth()->user()->id)
            ->get();
        return view('user.reciept', compact('cart_items'));
    }

    //product page
    public function productDetailsPage($id)
    {
        $product = Product::
            select('products.*', 'categories.category')
            ->leftJoin("categories", "categories.id", "products.category_id")
            ->where("products.id", $id)->first();
            $price = Price::orderBy("price","asc")->first();
            // dd($price);
        if (!$product) {
            return redirect()->route('shopPage')->with('error', 'Product not found.');
        }
        $colors = color::get();
        return view('user.productDetails', compact('product', 'colors',"price"));
    }

    //profile page
    public function profilePage()
    {
        return view('user.profile');
    }

    //order history
    public function orderHistoryPage()
    {
        $orders = DB::table('order_varifieds')
        ->select('order_varifieds.id', 'order_varifieds.order_code', "order_varifieds.checked")
        ->join('orders', 'order_varifieds.order_code', 'orders.order_code')
        ->join('users', 'orders.user_id', 'users.id')
        ->where("users.id", Auth::user()->id)
        ->groupBy('order_varifieds.id', 'order_varifieds.order_code', 'users.username', "order_varifieds.checked")
        ->get();
        return view('user.history.orderHistory', compact('orders'));
    }

    //rating page
    public function ratingHistoryPage()
    {
        $ratings = Rating::select('ratings.*', 'products.name', 'products.image', 'categories.category')
            ->leftJoin("products", "ratings.product_id", "products.id")
            ->leftJoin('categories', "products.category_id", "categories.id")
            ->where("ratings.user_id", Auth::user()->id)
            ->get();
        return view('user.history.ratingHistory', compact('ratings'));
    }

    // contact us page
    public function contactHistoryPage()
    {
        return view('user.history.contactHistory');
    }

    //order history details
    public function orderHistoryDetails($order_code)
    {
        $orders = Order::select("orders.*", "order_varifieds.checked", "products.name", "products.image", "categories.category", "price_confirmeds.price as actual_price")
            ->where("orders.user_id", Auth::user()->id)
            ->where('orders.order_code', $order_code)
            ->leftJoin("order_varifieds", "order_varifieds.order_code", "orders.order_code")
            ->leftJoin('products', 'orders.product_id', "products.id")
            ->leftJoin("price_confirmeds","price_confirmeds.order_id", "orders.id")
            ->leftJoin("categories", "categories.id", "products.category_id")
            ->get();
        return view('user.history.orderHistoryDetails', compact('orders', 'order_code'));
    }

    //user profile
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
