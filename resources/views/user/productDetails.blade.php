@extends('user.layouts.master')
@section('main')
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Shop</h1>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="hero-img-wrap">
                        <img src="{{ asset('user/images/couch.png') }}" style="width:70%; margin-left:125px;" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <div class="untree_co-section product-section before-footer-section">
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <img src="{{asset('products/'.$product->image)}}" class="w-100" alt="">
                </div>
                <div class="col-8">
                    <h3>{{$product->name}}</h3>
                    <h6>{{$product->category}}</h6>
                    <p>{{$product->description}}</p>
                    <form action="{{route('addProductDetails')}}" method="post">
                        @csrf
                        <input type="hidden" name="product_id">
                        <input type="text" name="width" class="form-control mt-3" placeholder="Enter Width">
                        <input type="text" name="length" class="form-control mt-3" placeholder="Enter Height">
                        <select name="color" id="" class="form-control mt-3">
                            @foreach ($colors as $c)
                            <option value="{{$c->id}}">{{$c->color}}</option>
                            @endforeach
                        </select>
                        <input class="btn mt-3" type="submit" value="Add To Cart"></input>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
