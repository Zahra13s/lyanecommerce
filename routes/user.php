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

    //create
    Route::get('/add/to/cart/{id}', [CreateController::class, 'addToCart'])->name('addToCart');
    Route::post('/place-order', [CreateController::class, 'placeOrder'])->name('placeOrder');
    Route::post('/create/comment', [CreateController::class, 'createComment'])->name('createComment');
    Route::post('/create/favourite', [CreateController::class, 'createFavourite'])->name('createFavourite');
    Route::post('/create/save', [CreateController::class, 'createSave'])->name('createSave');

    Route::get('/shop/filter/product', [CreateController::class, 'filterProducts'])->name('filterProducts');


    Route::post('/cart/update', [UpdateController::class, 'update'])->name('cart.update');

    Route::get('/cart/delete/{id}', [DeleteController::class, 'delete'])->name('cart.delete');


});
