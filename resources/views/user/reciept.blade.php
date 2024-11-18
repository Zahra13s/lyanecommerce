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
                            Amount To Pay
                        </h3>
                        <p class="total"></p>
                    </div>
                </div>
            </div>
          <div class="row">
            <div class="col-md-6 offset-3">
              <div class="row mb-5">
                <div class="col-md-12">
                  <h2 class="h3 mb-3 text-black">Your Order</h2>
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
                          <td>{{ $c->name }} <strong class="mx-2">x</strong> {{ $c->qty }}</td>
                          <td>{{ $c->sub_total }}</td>
                        </tr>
                        @endforeach

                        @php
                          // Calculate the subtotal only once
                          $subtotal = $cart_items->sum('sub_total');
                          $shipping_fee = 10; // Example shipping fee
                          $total = $subtotal + $shipping_fee;
                        @endphp

                        <tr>
                          <td><strong>Sub Total</strong></td>
                          <td>{{ $subtotal }}</td>
                        </tr>
                        <tr>
                          <td><strong>Shipping Fees</strong></td>
                          <td>{{ $shipping_fee }}</td>
                        </tr>
                        <tr>
                          <td><strong>Total</strong></td>
                          <td>{{ $total }}</td>
                        </tr>
                      </tbody>
                    </table>


                    <div class="border p-3 mb-3">
                      <h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse" href="#collapsebank" role="button" aria-expanded="false" aria-controls="collapsebank">Direct Bank Transfer</a></h3>

                      <div class="collapse" id="collapsebank">
                        <div class="py-2">
                          <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                        </div>
                      </div>
                    </div>

                    <div class="border p-3 mb-3">
                      <h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse" href="#collapsecheque" role="button" aria-expanded="false" aria-controls="collapsecheque">Cheque Payment</a></h3>

                      <div class="collapse" id="collapsecheque">
                        <div class="py-2">
                          <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                        </div>
                      </div>
                    </div>

                    <div class="border p-3 mb-5">
                      <h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse" href="#collapsepaypal" role="button" aria-expanded="false" aria-controls="collapsepaypal">Paypal</a></h3>

                      <div class="collapse" id="collapsepaypal">
                        <div class="py-2">
                          <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                        </div>
                      </div>
                    </div>

               <div class="row">
                <div class="col d-flex justify-content-evenly">
                    <div class="form-group">
                        <button class="btn btn-black btn-lg py-3 btn-block" onclick="window.location='thankyou.html'">Place Order</button>
                      </div>
                      <div class="form-group">
                       <a href="{{route('cartPage')}}"> <button class="btn btn-black btn-lg py-3 btn-block" onclick="window.location='thankyou.html'">Edit Cart</button></a>
                      </div>
                </div>
               </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- </form> -->
        </div>
      </div>
@endsection
