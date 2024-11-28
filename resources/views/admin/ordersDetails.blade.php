@extends('admin.layout.master')

@section('main')
    <div class="row p-3">
        <div class="col-4">
            @if ($ov_image)
                <img src="{{ asset('order_varified/' . $ov_image->image) }}" alt="Order Image" class="w-75">
            @endif

            <div class="row mt-2">
                <div class="col">
                    <a href="{{ route('comfirmOrders', $orderCode) }}">
                        <button class="btn btn-success">
                            <i data-feather="check" class="me-2"></i> Confirm
                        </button>
                    </a>

                    <a href="{{ route('deniedOrders', $orderCode) }}">
                        <button class="btn btn-danger">
                            <i data-feather="x" class="me-2"></i> Denied
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
                        <img src="{{ asset('products/' . $o->product_image) }}" alt="Product Image" class="w-50 mb-2">
                        <form action="{{route('priceConfirmed')}}" method="POST">
                            @csrf
                            <input type="hidden" name="order_id" value="{{$o->order_id}}">
                            <input type="number" name="price" id="" class="form-control" placeholder="Enter the price">
                            <input type="submit" value="Confirm" class="btn btn-secondary mt-2">
                        </form>
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
                                <p>${{ number_format($o->order_price, 2) }}</p>
                                <p> {{ $o->qty }}</p>
                                <p> ${{ number_format($o->sub_total, 2) }}</p>
                                <p>{{$o->username}}</p>
                                <p>{{ $o->email }}</p>
                                <p> {{ $o->width }} x {{ $o->length }}</p>
                                <p>{{ $o->color }} </p>
                            </div>
                        </div>
                          <br>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
