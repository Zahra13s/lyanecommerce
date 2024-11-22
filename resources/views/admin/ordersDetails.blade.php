@extends('admin.layout.master')

@section('main')
    <div class="row p-3">
        <div class="col-4">
            <!-- Display the image of the first order (if available) -->
            @if ($ov_image)
                <img src="{{ asset('storage/' . $ov_image->image) }}" alt="Order Image" class="w-75">
            @endif

            <div class="row mt-2">
                <div class="col">
                    <button class="btn btn-success"><i data-feather="check" class="me-2"></i> Confirm</button>
                    <button class="btn btn-danger"><i data-feather="x" class="me-2"></i> Denied</button>
                </div>
            </div>
        </div>

        <div class="col-6">
            <h4>Order Details</h4>
            @foreach ($orders as $o)
                <div class="row my-2">
                    <div class="col-4">
                        <!-- Optionally display product image -->
                        <img src="{{ asset('products/' . $o->product_image) }}" alt="Product Image" class="w-50">
                    </div>
                    <div class="col-6">
                        <strong>Product:</strong> {{ $o->product_name }} <br>
                        <strong>Category:</strong> {{ $o->product_category }} <br>
                        <strong>Price:</strong> ${{ number_format($o->product_price, 2) }} <br>
                        <strong>Quantity:</strong> {{ $o->qty }} <br>
                        <strong>Sub Total:</strong> ${{ number_format($o->sub_total, 2) }} <br>
                        <strong>User:</strong> {{ $o->username }} <br>
                        <strong>User Email:</strong> {{ $o->email }} <br>
                        <strong>Width x Length:</strong> {{ $o->width }} x {{ $o->length }}  <br>
                        <strong>Color:</strong> {{ $o->color }}  <br>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
