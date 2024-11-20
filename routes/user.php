<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

Route::middleware('user')->prefix('user')->group(function () {
    //read
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('Userdashboard');
    Route::get('/shop/page', [UserController::class, 'shopPage'])->name('shopPage');
    Route::get('/aboutUs/page', [UserController::class, 'aboutUsPage'])->name('aboutUsPage');
    Route::get('/blog/page', [UserController::class, 'blogPage'])->name('blogPage');
    Route::get('/contactUs/page', [UserController::class, 'contactUsPage'])->name('contactUsPage');
    Route::get('/cart/page', [UserController::class, 'cartPage'])->name('cartPage');
    Route::get('recipe/page',[UserController::class, 'reciepePage'])->name('reciepePage');
    Route::get('blog/details/{id}',[UserController::class, 'blogDetails'])->name('blogDetails');
    //create
    Route::get('/add/to/cart/{id}', [UserController::class, 'addToCart'])->name('addToCart');
    Route::post('/add/comment', [UserController::class, 'addComment'])->name('addComment');
    Route::post('/place-order', [UserController::class, 'store'])->name('placeOrder');
    Route::post('/add/favourite', [UserController::class, 'addFavourite'])->name('addFavourite');
    Route::post('/add/save', [UserController::class, 'addSave'])->name('addSave');

    Route::post('/cart/update', [UserController::class, 'update'])->name('cart.update');
    Route::get('/cart/delete/{id}', [UserController::class, 'delete'])->name('cart.delete');


});
