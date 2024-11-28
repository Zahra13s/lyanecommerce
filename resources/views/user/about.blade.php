@extends('user.layouts.master')
@section('main')
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>About Us</h1>
                        <p class="mb-4">Lyan creates elegant calligraphy and decor, turning your special moments into
                            lasting memories with personalized, handcrafted designs.</p>
                        <p><a href="{{ route('shopPage') }}" class="btn btn-secondary me-2">Shop Now</a>
                            <a href="{{ route('blogPage') }}" class="btn btn-white-outline">Explore</a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="hero-img-wrap">
                        <img src="{{ asset('user/images/couch.png') }}" style="width:80%; margin-left:75px;"
                            class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <!-- Start Why Choose Us Section -->
    <div class="why-choose-section">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title">Why Choose Us</h2>
                    <p>We offer exceptional quality, timeless design, and meticulous craftsmanship, ensuring every piece
                        enhances your space with elegance and durability.</p>

                    <div class="row my-5">
                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{ asset('user/images/truck.svg') }}" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Fast &amp; Free Shipping</h3>
                                <p>Enjoy quick and reliable delivery, with no extra cost. We ensure your order arrives
                                    safely and on time, so you can start enjoying your new space sooner.</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{ asset('user/images/bag.svg') }}" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Easy to Shop</h3>
                                <p>Browse effortlessly and find exactly what you need. Our user-friendly platform ensures a
                                    smooth shopping experience, from selection to checkout.</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{ asset('user/images/support.svg') }}" alt="Image" class="imf-fluid">
                                </div>
                                <h3>24/7 Support</h3>
                                <p>Our dedicated team is always available to assist you. Whether you have questions or need
                                    help, we're here to provide reliable support anytime, day or night.</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="{{ asset('user/images/return.svg') }}" alt="Image" class="imf-fluid">
                                </div>
                                <h3>Hassle Free Returns</h3>
                                <p>Enjoy peace of mind with our easy returns process. If you're not completely satisfied, we
                                    make it simple to return your items without any hassle.</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="img-wrap">
                        <img src="{{ asset('user/images/why-choose-us-img.jpg') }}" alt="Image" class="img-fluid">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Why Choose Us Section -->

    <!-- Start Team Section -->
    <div class="untree_co-section">
        <div class="container">

            <div class="row mb-5">
                <div class="col-lg-5 mx-auto text-center">
                    <h2 class="section-title">Our Team</h2>
                </div>
            </div>
            <div class="row ovetflow-x-scroll">
                @foreach ($admins as $a)
                    <!-- Start Column 1 -->
                    <div class="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
                        <img src="{{ asset('user/images/person_1.jpg') }}" class="img-fluid mb-5">
                        <h3 clas><a href="#">{{$a->name}}</a></h3>
                        <span class="d-block position mb-4">{{$a->username}}</span>
                    </div>
                    <!-- End Column 1 -->
                @endforeach
            </div>
        </div>
    </div>
    <!-- End Team Section -->
@endsection
