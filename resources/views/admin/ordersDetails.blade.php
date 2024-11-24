@extends('admin.layout.master')

@section('main')
    <div class="row p-3">
        <div class="col-4">
            <!-- Display the image of the first order (if available) -->
            @if ($ov_image)
                <img src="{{ asset('order_varified/' . $ov_image->image) }}" alt="Order Image" class="w-75">
            @endif

            <div class="row mt-2">
                <div class="col">
                    <a href="{{ route('checkOrders', $orderCode) }}">
                        <button class="btn btn-success">
                            <i data-feather="check" class="me-2"></i> Confirm
                        </button>
                    </a>

                </div>
            </div>
        </div>

        <div class="col-6">
            <h4>Order Details</h4>
            @foreach ($orders as $o)
                <div class="row my-2">
                    <div class="col-4">
                        <img src="{{ asset('products/' . $o->product_image) }}" alt="Product Image" class="w-50">
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-6">
                                <p><strong>Product:</strong></p>
                                <p><strong>Category:</strong></p>
                                <p><strong>Price:</strong></p>
                                <p><strong>Quantity:</strong></p>
                                <p><strong>Sub Total:</strong></p>
                                <p><strong>User:</strong></p>
                                <p><strong>User Email:</strong></p>
                                <p><strong>Width x Length:</strong></p>
                                <p><strong>Color:</strong></p>
                                  <br>
                            </div>
                            <div class="col-6">
                                <p>{{ $o->product_name }}</p>
                                <p>{{ $o->product_category }}</p>
                                <p>${{ number_format($o->product_price, 2) }}</p>
                                <p> {{ $o->qty }}</p>
                                <p> ${{ number_format($o->sub_total, 2) }}</p>
                                <p>{{$o->username}}</p>
                                <p>{{ $o->email }}</p>
                                <p> {{ $o->width }} x {{ $o->length }}</p>
                                <p>{{ $o->color }} </p>
                                <p></p>
                                <p></p>
                                <p></p>
                            </div>
                        </div>
                          <br>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
