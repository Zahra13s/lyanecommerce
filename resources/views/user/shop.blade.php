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
                <div class="col-12 col-md-4 col-lg-2 mb-5">
                    <h3>Filter By Category</h3>
                    <ul class="m-0 p-0">
                        <li class="card my-2 p-2">
                            <a style="text-decoration: none" href="{{ route('shopPage') }}" class="{{ request('category') == null ? 'active' : '' }}"><strong>All</strong></a>
                        </li>
                        @foreach ($categories as $c)
                            <li class="card my-2 p-2">
                                <a style="text-decoration: none" href="{{ route('shopPage', ['category' => $c->id]) }}"
                                   class="{{ request('category') == $c->id ? 'active' : '' }}">
                                    <strong>
                                        {{ $c->category }}
                                    </strong>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-12 col-md-8 col-lg-10">
                    <div class="row p-5">
                        @foreach ($products as $p)
                            <div class="col-12 col-md-4 col-lg-3 mb-5">
                                <a class="product-item" href="{{ route('productDetailsPage', $p->id) }}">
                                    <img src="{{ asset('products/' . $p->image) }}"
                                         style="width: 200px; height: 200px; object-fit: cover;" class="img-fluid product-thumbnail">
                                    <h3 class="product-title">{{ $p->name }}</h3>
                                    <strong class="product-price">{{ $p->price }}</strong>
                                    <span class="icon-cross">
                                        <img src="{{ asset('user/images/cross.svg') }}" class="img-fluid">
                                    </span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                   <!-- Pagination Links -->
       <div class="d-flex justify-content-end">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
            </div>
        </div>
    </div>
@endsection
