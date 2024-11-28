<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use App\Models\color;
use App\Models\Price;
use App\Models\Reply;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PriceConfirmed;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    //price create
    public function addPrice(Request $request)
    {
        $validated = $request->validate([
            'price' => 'required',
        ]);

        $data = Price::create([
            'price' => $request->price,
        ]);
        return back()->with('success', 'Your price has been submitted successfully!');
    }

    //category create
    public function addCategory(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required',
        ]);

        $data = Category::create([
            'category' => $request->category,
        ]);
        return back()->with('success', 'Your category has been submitted successfully!');
    }

    //colors create
    public function addColor(Request $request)
    {
        $validated = $request->validate([
            'color' => 'required',
        ]);

        $data = color::create([
            'color' => $request->color,
        ]);
        return back()->with('success', 'Your color has been submitted successfully!');
    }

    //product create
    public function addProduct(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'category' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($request->hasFile('image')) {
            $fileName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('products'), $fileName);
            $imagePath = $fileName;
        }

        Product::create([
            'name' => $validated['name'],
            'category_id' => $validated['category'],
            'image' => $imagePath,
            'description' => $validated['description'],
        ]);

        return back()->with('success', 'Your product has been submitted successfully!');
    }

    //blog create
    public function addBlog(Request $request)
    {
        $validated = $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required|string|max:255',
            'text' => 'nullable|string|max:1000',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $fileName = uniqid() . '_' . $image->getClientOriginalName();
                $image->move(public_path('blogs'), $fileName);
                $imagePaths[] = $fileName;
            }
        }

        Blog::create([
            'title' => $validated['title'],
            'text' => $validated['text'],
            'image' => json_encode($imagePaths),
            'author_name' => auth()->user()->name,
        ]);
        return back()->with('success', 'Blog post created successfully!');
    }

    // reply to blogs comment
    public function Reply(Request $request)
    {

        $reply = Reply::create([
            "comment_id" => $request->comment_id,
            "reply" => $request->reply,
            "admin_id" => Auth::user()->id,
        ]);
        return back()->with('success', 'Your blog has been submitted successfully!');
    }

    //price confirm
    public function priceConfirmed(Request $request){
        $validated = $request->validate([
            'price' => 'required'
        ]);

        PriceConfirmed::create(['order_id' => $request->order_id ,'price' => $request->price]);
        return back()->with('success', 'Your price confirmed has been submitted successfully!');
    }
}
