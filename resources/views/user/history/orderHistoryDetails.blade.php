@extends('user.layouts.master')
@section('main')

    <!-- Start Why Choose Us Section -->
    <div class="why-choose-section">
        <div class="container">
            <div class="row">
                <h5>Order Code: {{$order_code}}</h5>
            </div>
            <div class="row justify-content-between align-items-center">
                <table class="table">
                    <thead>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <td scope="col">Sub Total</td>

                    </thead>
                    <tbody>
                        @foreach ($orders as $o)
                       <tr>
                         <td><img src="{{asset('products/'.$o->image)}}" alt="" width="100px"></td>
                         <td>{{$o->name}}</td>
                         <td>{{$o->category}}</td>
                         <td>{{$o->actual_price}}</td>
                         <td>{{$o->qty}}</td>
                         <td>{{$o->actual_price * $o->qty}}
                            <br>

                         </td>
                       </tr>
                        @endforeach
                        <small class="text-warning">If the price is overpayed, I'll get that back to you with the product. If the price is need, please transfer it to be double confimed the orders.</small>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Why Choose Us Section -->
@endsection
