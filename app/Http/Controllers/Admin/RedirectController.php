<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderVarified;
use App\Models\Price;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RedirectController extends Controller
{
    //
    //redirects
    public function dashboard()
    {
        return view('admin.dashboard');
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
        $data = DB::table('categories')->paginate(15);

        $product_counts = DB::table('products')
            ->select('category_id', DB::raw('count(*) as product_count'))
            ->groupBy('category_id')
            ->get();

        $categoryProductCounts = [];
        foreach ($product_counts as $product) {
            $categoryProductCounts[$product->category_id] = $product->product_count;
        }

        return view('admin.category', compact('data', 'categoryProductCounts'));
    }

    public function productsPage()
    {
        $data = Category::get();
        $product = Product::select('products.*', 'categories.id as category_id', 'categories.category')
            ->leftJoin('categories', 'products.category_id', 'categories.id')->paginate(5);
        return view('admin.product', compact('data', 'product'));
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

        $orders = Order::select("orders.*", "order_varifieds.order_code", "order_varifieds.image", "order_varifieds.checked")
                  ->leftJoin("order_varifieds", "orders.order_code", "order_varifieds.order_code")
                  ->get();
        return view('admin.ordersReply', compact('orderDisplay', 'orders'));
    }
}
