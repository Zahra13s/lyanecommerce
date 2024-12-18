@extends('user.layouts.master')
@section('main')
<style>
    .star-rating {
        display: flex;
        direction: row;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        font-size: 30px;
        color: #ccc;
        cursor: pointer;
        transition: color 0.3s ease;
        padding: 0 5px;
    }

    .star-rating label.selected {
        color: #FFD700;
    }
</style>

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
            <div class="col-4">
                <img src="{{ asset('products/' . $product->image) }}" class="w-100" alt="">
            </div>
            <div class="col-8">
                <h3>{{ $product->name }}</h3>
                <h6>{{ $product->category }}</h6>
                <h6 class="mb-3">Price: {{ ($price->price  + 3500)}} ~ {{($price->price +3000+5000)  }} </h6>
                <small class="text-danger alert alert-danger my-2">
                    <i data-feather="alert-triangle"></i>
                    Be aware that, this price is for 1sqft price only.</small>
                    <h6 class="mt-3"><strong>Calculated Price:</strong> <span id="calculated-price">0</span> </h6>
                <p>{{ $product->description }}</p>
                <form action="{{ route('addProductDetails') }}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="text" id="width" name="width" class="form-control mt-3" placeholder="Enter Width">
                    <input type="text" id="length" name="length" class="form-control mt-3" placeholder="Enter Height">
                    <select name="color_id" class="form-control mt-3">
                        @foreach ($colors as $c)
                        <option value="{{ $c->id }}">{{ $c->color }}</option>
                        @endforeach
                    </select>
                    <div class="d-flex align-items-center mt-3">
                        <input class="btn me-2" type="submit" value="Add To Cart">
                        <!-- Rating Button -->
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ratingModal">
                            Rate Product
                        </button>
                    </div>
                </form>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const pricePerSqFt = {{ $price->price }};
                        const minadditionalCostPerSqFt = 3500;
                        const maxadditionalCostPerSqFt = 5000;
                        const calculatedPriceElement = document.getElementById('calculated-price');
                        const widthInput = document.getElementById('width');
                        const lengthInput = document.getElementById('length');

                        function calculatePrice() {
                            const width = parseFloat(widthInput.value) || 0;
                            const length = parseFloat(lengthInput.value) || 0;
                            const sqFeet = (width * length) / 144;
                            const minPrice = sqFeet > 0 ? (sqFeet * pricePerSqFt) + (sqFeet * minadditionalCostPerSqFt) : 0;
                            const maxPrice = sqFeet > 0 ? (sqFeet * (pricePerSqFt + 3000)) + (sqFeet * maxadditionalCostPerSqFt) : 0;
                            console.log(minPrice);
                            console.log(maxPrice);
                            calculatedPriceElement.textContent = `${minPrice.toFixed(2)} ~ ${maxPrice.toFixed(2) }` ;
                        }

                        widthInput.addEventListener('input', calculatePrice);
                        lengthInput.addEventListener('input', calculatePrice);
                    });
                </script>
            </div>
        </div>
    </div>
</div>

@if (session('showRatingModal'))
<script>
    window.onload = function () {
        $('#ratingModal').modal('show');
    }
</script>
@endif

<div class="modal" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel">Rate the Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('productRate') }}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="star-rating">
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1"><i data-feather="star"></i></label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2"><i data-feather="star"></i></label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3"><i data-feather="star"></i></label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4"><i data-feather="star"></i></label>
                        <input type="radio" id="star5" name="rating" value="5">
                        <label for="star5"><i data-feather="star"></i></label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Submit Rating</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const stars = document.querySelectorAll('.star-rating input');
    const labels = document.querySelectorAll('.star-rating label');

    stars.forEach((star, index) => {
        star.addEventListener('change', () => {

            labels.forEach(label => label.classList.remove('selected'));

            for (let i = 0; i <= index; i++) {
                labels[i].classList.add('selected');
            }
        });
    });
</script>

@endsection
