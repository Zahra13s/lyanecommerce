<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
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

    public function productRating(){
        return view('admin.productRating');
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
            ->join('product_requests','product_requests.order_id','orders.id')
            ->join('colors','colors.id','product_requests.color_id')
            ->where('orders.order_code', $order_code)
            ->get();

        $ov_image = DB::table('order_varifieds')
            ->select('image')
            ->where('order_code', $order_code)
            ->first();

        return view('admin.ordersDetails', compact('ov_image', 'orders'));
    }


}
