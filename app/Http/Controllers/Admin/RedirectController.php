<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Order;
use App\Models\OrderVarified;
use App\Models\Price;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RedirectController extends Controller
{


    public function dashboard()
    {
        // Define current and last week's date ranges
        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd = Carbon::now()->endOfWeek();
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();

        // Current week data
        $currentWeekSales = OrderVarified::leftJoin("orders", "orders.order_code", "order_varifieds.order_code")
            ->where("order_varifieds.checked", 1)
            ->whereBetween("orders.created_at", [$currentWeekStart, $currentWeekEnd])
            ->count();

        $currentWeekEarnings = OrderVarified::leftJoin("orders", "orders.order_code", "order_varifieds.order_code")
            ->where("order_varifieds.checked", 1)
            ->whereBetween("orders.created_at", [$currentWeekStart, $currentWeekEnd])
            ->sum("orders.sub_total");

        $currentWeekOrders = OrderVarified::where("order_varifieds.checked", 0)
            ->whereBetween("created_at", [$currentWeekStart, $currentWeekEnd])
            ->count();

        $currentWeekVisitors = User::where("role", "user")
            ->whereBetween("created_at", [$currentWeekStart, $currentWeekEnd])
            ->count();

        // Last week data
        $lastWeekSales = OrderVarified::leftJoin("orders", "orders.order_code", "order_varifieds.order_code")
            ->where("order_varifieds.checked", 1)
            ->whereBetween("orders.created_at", [$lastWeekStart, $lastWeekEnd])
            ->count();

        $lastWeekEarnings = OrderVarified::leftJoin("orders", "orders.order_code", "order_varifieds.order_code")
            ->where("order_varifieds.checked", 1)
            ->whereBetween("orders.created_at", [$lastWeekStart, $lastWeekEnd])
            ->sum("orders.sub_total");

        $lastWeekOrders = OrderVarified::where("order_varifieds.checked", 0)
            ->whereBetween("created_at", [$lastWeekStart, $lastWeekEnd])
            ->count();

        $lastWeekVisitors = User::where("role", "user")
            ->whereBetween("created_at", [$lastWeekStart, $lastWeekEnd])
            ->count();

        // Calculate percentage changes
        $salesChange = $lastWeekSales == 0 ? 0 : (($currentWeekSales - $lastWeekSales) / $lastWeekSales) * 100;
        $earningsChange = $lastWeekEarnings == 0 ? 0 : (($currentWeekEarnings - $lastWeekEarnings) / $lastWeekEarnings) * 100;
        $ordersChange = $lastWeekOrders == 0 ? 0 : (($currentWeekOrders - $lastWeekOrders) / $lastWeekOrders) * 100;
        $visitorsChange = $lastWeekVisitors == 0 ? 0 : (($currentWeekVisitors - $lastWeekVisitors) / $lastWeekVisitors) * 100;

    $dates = [];
    $orderCounts = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::today()->subDays($i)->format('Y-m-d');
        $dates[] = $date;

        $orderCount = Order::whereDate('created_at', $date)->count();
        $orderCounts[] = $orderCount;
    }

        return view('admin.dashboard', compact(
            'currentWeekSales',
            'currentWeekEarnings',
            'currentWeekVisitors',
            'currentWeekOrders',
            'salesChange',
            'earningsChange',
            'visitorsChange',
            'ordersChange',
            'dates',
            'orderCounts'
        ));
    }


    public function addAdminsPage()
    {
        $user = User::paginate(10);
        return view('admin.addadmins', compact('user'));
    }

    public function pricePage()
    {
        $data = Price::paginate(10);
        return view('admin.price', compact('data'));
    }

    public function categoriesPage()
    {
        $data = DB::table('categories')->paginate(10);

        $product_counts = DB::table('products')
            ->select('category_id', DB::raw('count(*) as product_count'))
            ->groupBy('category_id')
            ->paginate(10);

        $categoryProductCounts = [];
        foreach ($product_counts as $product) {
            $categoryProductCounts[$product->category_id] = $product->product_count;
        }

        return view('admin.category', compact('data', 'categoryProductCounts'));
    }

    public function colorsPage()
    {
        $data = DB::table('colors')->paginate(15);
        return view('admin.color', compact('data'));
    }

    public function productsPage()
    {
        $data = Category::get();
        $product = Product::select('products.*', 'categories.id as category_id', 'categories.category')
            ->leftJoin('categories', 'products.category_id', 'categories.id')->paginate(3);
        return view('admin.product', compact('data', 'product'));
    }

    public function productRating()
    {
        $ratings = Rating::select("ratings.*", "products.name", "categories.category", "users.username")
            ->leftJoin("products", "ratings.product_id", "products.id")
            ->leftJoin("categories", "categories.id", "products.category_id")
            ->leftJoin("users", "users.id", "ratings.user_id")
            ->get();
        return view('admin.productRating', compact('ratings'));
    }

    public function blogsPage()
    {
        $blogs = Blog::all();
        return view('admin.blogs', compact('blogs'));
    }

    public function profilePage()
    {
        return view('admin.profile');
    }

    public function ordersReply()
    {
        $orderDisplay = DB::table('order_varifieds')
            ->select('order_varifieds.id', 'order_varifieds.order_code', 'users.username')
            ->join('orders', 'order_varifieds.order_code', 'orders.order_code')
            ->join('users', 'orders.user_id', 'users.id')
            ->groupBy('order_varifieds.id', 'order_varifieds.order_code', 'users.username')
            ->get();

        return view('admin.ordersReply', compact('orderDisplay'));
    }

    public function orderDetails($order_code)
    {
        $orders = DB::table('orders')
            ->select(
                'orders.order_code',
                'users.username',
                'users.email',
                'products.name as product_name',
                'products.image as product_image',
                'products.price as product_price',
                'products.description as product_description',
                'orders.qty',
                'orders.sub_total',
                'orders.price as order_price',
                'order_varifieds.image as order_image',
                'categories.category as product_category',
                'product_requests.width',
                'product_requests.length',
                'colors.color'
            )
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->join('order_varifieds', 'orders.order_code', '=', 'order_varifieds.order_code')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('product_requests', 'product_requests.order_id', 'orders.id')
            ->join('colors', 'colors.id', 'product_requests.color_id')
            ->where('orders.order_code', $order_code)
            ->get();

        $ov_image = DB::table('order_varifieds')
            ->select('image')
            ->where('order_code', $order_code)
            ->first();

        $orderCode = $order_code;

        return view('admin.ordersDetails', compact('ov_image', 'orders', 'orderCode'));
    }

    public function blogComment()
    {
        $comments = Comment::select("comments.*", "blogs.title", "users.username", "replies.reply")
            ->leftJoin("blogs", "comments.blog_id", "blogs.id")
            ->leftJoin("users", "comments.user_id", "users.id")
            ->leftJoin("replies", "replies.comment_id", "comments.id")
            ->get();
        return view('admin.blogComment', compact('comments'));
    }

}
