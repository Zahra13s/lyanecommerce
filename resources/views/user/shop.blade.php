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
                    <ul>
                        <li>
                            <a href="{{ route('shopPage') }}" class="{{ request('category') == null ? 'active' : '' }}">All</a>
                        </li>
                        @foreach ($categories as $c)
                            <li>
                                <a href="{{ route('shopPage', ['category' => $c->id]) }}"
                                   class="{{ request('category') == $c->id ? 'active' : '' }}">
                                    {{ $c->category }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-12 col-md-8 col-lg-10 mb-5">
                    <div class="row">
                        @foreach ($products as $p)
                            <div class="col-12 col-md-4 col-lg-3">
                                <a class="product-item" href="{{ route('addToCart', $p->id) }}">
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
            </div>
        </div>
    </div>
@endsection
