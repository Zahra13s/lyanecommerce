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
                         <td>{{$o->price}}</td>
                         <td>{{$o->qty}}</td>
                         <td>{{$o->sub_total}}</td>
                       </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Why Choose Us Section -->
@endsection
