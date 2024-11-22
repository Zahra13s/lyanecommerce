@extends('user.layouts.master')

@section('main')
    <!-- Cart Page Header -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Cart</h1>
                    </div>
                </div>
                <div class="col-lg-7">
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Table Section -->
    <div class="untree_co-section before-footer-section">

        <form class="col-md-12" method="POST" action="{{ route('cart.update') }}">
            @csrf <div class="container">
                <div class="row mb-5">
                    <div class="site-blocks-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">Image</th>
                                    <th class="product-name">Product</th>
                                    <th class="product-details">Details</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Total</th>
                                    <th class="product-remove">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart_items as $c)
                                    <input type="hidden" name="items[{{ $loop->index }}][id]" value="{{ $c->id }}">

                                    <tr>
                                        <td class="product-thumbnail">
                                            <img src="{{ asset('products/' . $c->image) }}" alt="Image"
                                                class="img-fluid">
                                        </td>
                                        <td class="product-name">
                                            <h2 class="h5 text-black">{{ $c->name }}</h2>
                                        </td>
                                        <td class="product-details">
                                            <ul>
                                                <li>{{ $c->id }}</li>
                                                <li>{{ $c->width }} x {{ $c->length }}</li>
                                                <li>{{ $c->color }}</li>
                                            </ul>
                                        </td>
                                        <td class="product-price">{{ $c->price }} mmk</td>
                                        <td class="product-quantity">
                                            <input type="hidden" name="items[{{ $loop->index }}][id]"
                                                value="{{ $c->id }}">
                                            <div class="input-group mb-3 d-flex align-items-center"
                                                style="max-width: 120px;">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-black decrease"
                                                        type="button">&minus;</button>
                                                </div>
                                                <input type="number" class="form-control text-center quantity-amount"
                                                    name="items[{{ $loop->index }}][quantity]" value="{{ $c->qty }}"
                                                    id="quantity-{{ $loop->index }}" min="1">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-black increase"
                                                        type="button">&plus;</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="product-total text-end " id="total-{{ $loop->index }}">
                                            {{ $c->price * $c->qty }}mmk</td>
                                        <td>
                                            <a href="{{ route('cart.delete', $c->id) }}"
                                                class="btn btn-black btn-sm btn-remove"
                                                data-cart-id="{{ $c->id }}">X</a>

                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th class=" " colspan="4"><h3>Total</h3></th>
                                    <th class=" p-3 text-end cart-subtotal"><span id="cart-subtotal">mmk</span></th>
                                    <th class="">(without shipping)</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
      <div class="row">
       <div class="col-md-4 offset-8 d-flex justify-content-evenly">
        <div class="">
            <button type="submit" class="btn btn-black btn-sm btn-block">Update Cart</button>
        </div>
        <div class="">
            <a href="{{route('reciepePage')}}"><button type="button" class="btn btn-black btn-sm btn-block">Proceed to checkout</button></a>
        </div>
       </div>
      </div>
        </form>
    </div>



    </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function updateTotal(index) {
                const price = parseFloat(document.querySelector(`#quantity-${index}`).closest("tr").querySelector(
                    ".product-price").innerText);
                const quantity = parseInt(document.getElementById(`quantity-${index}`).value);
                const total = price * quantity;
                document.querySelector(`#total-${index}`).innerText = `${Math.round(total)}mmk`;
                updateCartTotal();
            }

            function updateCartTotal() {
                let cartTotal = 0;
                document.querySelectorAll('.product-total').forEach((productTotal) => {
                    cartTotal += parseFloat(productTotal.innerText) || 0;
                });
                document.querySelector('#cart-subtotal').innerText = `${Math.round(cartTotal)}mmk`;
            }

            document.querySelectorAll(".decrease").forEach((button, index) => {
                button.addEventListener("click", function() {
                    const quantityInput = button.closest("tr").querySelector(".quantity-amount");
                    let quantity = parseInt(quantityInput.value);
                    if (quantity > 1) {
                        quantityInput.value = quantity - 1;
                        updateTotal(index);
                    }
                });
            });

            document.querySelectorAll(".increase").forEach((button, index) => {
                button.addEventListener("click", function() {
                    const quantityInput = button.closest("tr").querySelector(".quantity-amount");
                    let quantity = parseInt(quantityInput.value);
                    quantityInput.value = quantity + 1;
                    updateTotal(index);
                });
            });

            document.querySelectorAll('.btn-remove').forEach((button) => {
                button.addEventListener('click', function(e) {

                    e.preventDefault();
                    const cartId = button.getAttribute('data-cart-id');
                    fetch(`/user/cart/delete/${cartId}`, {
                            method: 'GET',
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message === 'success') {
                                location.reload();
                            }
                        });
                });
            });

            updateCartTotal();
        });
    </script>
@endsection
