@extends('user.layouts.master')

@section('main')
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Checkout</h1>
                    </div>
                </div>
                <div class="col-lg-7">

                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <div class="untree_co-section">
        <div class="container">
            <div class="row mb-2">
                <div class="col-md-6 offset-3">
                    <div class="p-3 p-lg-5 border bg-white">
                        <h3 class="text-center">
                            <h2 class="h3 mb-3 text-black text-center">Your Order</h2>
                        </h3>
                        <p class="total"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 offset-3">
                    <div class="row mb-5">
                        <div class="col-md-12">

                            <div class="p-3 p-lg-5 border bg-white">
                                <table class="table site-block-order-table mb-5">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart_items as $c)
                                            <tr>
                                                <td>{{ $c->name }} <strong class="mx-2">x</strong>
                                                    {{ $c->qty }}</td>
                                                <td>{{ $c->sub_total }}</td>
                                            </tr>
                                        @endforeach

                                        @php
                                            $subtotal = $cart_items->sum('sub_total');
                                            $shipping_fee = 10;
                                            $total = $subtotal + $shipping_fee;
                                        @endphp

                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td>{{ $subtotal }}</td>
                                        </tr>
                                    </tbody>
                                </table>


                                <form action="{{ route('placeOrder') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="total_price" value="{{ $total }}">
                                    <div class="border p-3 mb-3">
                                        <label for="image">Upload Image</label>
                                        <input type="file" name="image" class="form-control" required>
                                    </div>

                                    <div class="row">
                                        <div class="col d-flex justify-content-evenly">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-black btn-lg py-3 btn-block">Place Order</button>
                                            </div>
                                            <div class="form-group">
                                                <a href="{{ route('cartPage') }}" class="btn btn-black btn-lg py-3 btn-block">Edit Cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- </form> -->
        </div>
    </div>
@endsection
