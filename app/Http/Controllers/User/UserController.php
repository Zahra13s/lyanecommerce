<?php

namespace App\Http\Controllers\User;

use App\Models\Blog;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //read
    public function dashboard(){
        $products = Product::limit(3)->get();
        $blogs = Blog::limit(3)->get();
        return view("user.dashboard", compact('products','blogs'));
    }

    public function shopPage(){
        $products = Product::limit(3)->get();
        return view("user.shop", compact('products'));
    }

    public function aboutUsPage(){
        return view("user.about");
    }

    public function servicesPage(){
        return view("user.services");
    }

    public function blogPage(){
        return view("user.blog");
    }

    public function contactUsPage(){
        return view("user.contact");
    }

    public function cartPage(){
        $cart_items = Cart::select('carts.*','products.name','products.image')
        ->leftJoin("products","products.id","carts.product_id")
        ->where("carts.user_id",auth()->user()->id)
        ->get();
        return view("user.cart",compact("cart_items"));
    }

    public function reciepePage(){
        $cart_items = Cart::select('carts.*','products.name','products.image')
        ->leftJoin("products","products.id","carts.product_id")
        ->where("carts.user_id",auth()->user()->id)
        ->get();
        return view('user.reciept',compact('cart_items'));
    }


    //create
    public function addToCart($id){
            $product = Product::findOrFail($id); // Assuming you have a Product model

            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $id,
                'price' => $product->price,  // Adjust based on your product's price field
                'qty' => 1,                  // Assuming a default quantity of 1
                'sub_total' => $product->price * 1, // Calculate based on quantity and price
            ]);

            return redirect()->back()->with('success', 'Product added to cart!');
    }

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
