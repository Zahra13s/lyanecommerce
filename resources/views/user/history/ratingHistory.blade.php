@extends('user.layouts.master')
@section('main')
    <div class="blog-section">
        <div class="container">
            <div class="row">
                    @foreach ($ratings as $r)
                        <div class="card col-6 col-md-4 col-lg-2 mb-4 py-2 mx-2">
                            <img src="{{ asset('products/' . $r->image) }}"
                                style="width: 200px; height: 200px; object-fit: cover;" class="img-fluid product-thumbnail">
                                <hr>
                                <h3 class="product-title">{{ $r->name }}</h3>
                                <small>{{$r->updated_at->format("M d, Y (D)")}}</small>
                            <strong class="product-price">{{ $r->price }}</strong>
                            <div class="d-flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i data-feather="star"
                                       class="{{ $i <= $r->comment ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
@endsection
