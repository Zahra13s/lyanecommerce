<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\CreateController;
use App\Http\Controllers\User\DeleteController;
use App\Http\Controllers\User\UpdateController;
use App\Http\Controllers\User\RedirectController;

Route::middleware('user')->prefix('user')->group(function () {
    //read
    Route::get('/dashboard', [RedirectController::class, 'dashboard'])->name('Userdashboard');
    Route::get('/shop/page', [RedirectController::class, 'shopPage'])->name('shopPage');
    Route::get('/aboutUs/page', [RedirectController::class, 'aboutUsPage'])->name('aboutUsPage');
    Route::get('/blog/page', [RedirectController::class, 'blogPage'])->name('blogPage');
    Route::get('blog/details/{id}',[RedirectController::class, 'blogDetails'])->name('blogDetails');
    Route::get('/contactUs/page', [RedirectController::class, 'contactUsPage'])->name('contactUsPage');
    Route::get('/cart/page', [RedirectController::class, 'cartPage'])->name('cartPage');
    Route::get('recipe/page',[RedirectController::class, 'reciepePage'])->name('reciepePage');
    Route::get('product/details/{id}', [RedirectController::class, 'productDetailsPage'])->name('productDetailsPage');
    Route::get('profile/page',[RedirectController::class, 'profilePage'])->name('profilePage');
    Route::get('order/history/page',[RedirectController::class, 'orderHistoryPage'])->name('orderHistoryPage');
    Route::get('rating/history/page',[RedirectController::class, 'ratingHistoryPage'])->name('ratingHistoryPage');
    Route::get('order/history/details/{order_code}', [RedirectController::class, 'orderHistoryDetails'])->name('orderHistoryDetails');
    Route::get('profile/page', [RedirectController::class, 'userProfilePage'])->name('userProfilePage');

    //create
    Route::get('/add/to/cart/{id}', [CreateController::class, 'addToCart'])->name('addToCart');
    Route::post('/place-order', [CreateController::class, 'placeOrder'])->name('placeOrder');
    Route::post('/create/comment', [CreateController::class, 'createComment'])->name('createComment');
    Route::post('/create/favourite', [CreateController::class, 'createFavourite'])->name('createFavourite');
    Route::post('/create/save', [CreateController::class, 'createSave'])->name('createSave');
    Route::get('/shop/filter/product', [CreateController::class, 'filterProducts'])->name('filterProducts');
    Route::post('/details/product', [CreateController::class, 'addProductDetails'])->name('addProductDetails');
    Route::post('product/rate', [CreateController::class, 'productRate'])->name('productRate');

    Route::post('/cart/update', [UpdateController::class, 'update'])->name('cart.update');
    Route::post('/profile/update', [UpdateController::class, 'userUpdateProfile'])->name('userUpdateProfile');

    Route::get('/cart/delete/{id}', [DeleteController::class, 'delete'])->name('cart.delete');


});
