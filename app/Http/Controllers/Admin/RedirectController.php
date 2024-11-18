<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\User;
use App\Models\Price;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RedirectController extends Controller
{
    //
        //redirects
        function dashboard(){
            return view('admin.dashboard');
        }

        function addAdminsPage(){
            $user = User::paginate(10);
            return view('admin.addadmins', compact('user'));
        }

        public function pricePage(){
        $data = Price::paginate(10);
            return view('admin.price',compact('data'));
        }


        public function categoriesPage()
    {
        // Fetch all categories
        $data = DB::table('categories')->paginate(15);

        // Fetch product counts grouped by category_id
        $product_counts = DB::table('products')
            ->select('category_id', DB::raw('count(*) as product_count'))
            ->groupBy('category_id')
            ->get();

        // Prepare product counts in an associative array
        $categoryProductCounts = [];
        foreach ($product_counts as $product) {
            $categoryProductCounts[$product->category_id] = $product->product_count;
        }

        return view('admin.category', compact('data', 'categoryProductCounts'));
    }

        public function productsPage(){
            $data = Category::get();
            $product = Product::select('products.*', 'categories.id as category_id', 'categories.category')
            ->leftJoin('categories', 'products.category_id', 'categories.id')->paginate(5);
            return view('admin.product',compact('data', 'product'));
        }

        public function blogsPage() {
            $blogs = Blog::all();
            return view('admin.blogs', compact('blogs'));
        }
}
