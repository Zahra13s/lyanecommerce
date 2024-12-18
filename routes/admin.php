<?php
use App\Http\Controllers\Admin\CreateController;
use App\Http\Controllers\Admin\DeleteController;
use App\Http\Controllers\Admin\RedirectController;
use App\Http\Controllers\Admin\UpdateController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->prefix('admin')->group(function () {
    //redirects
    Route::get('/dashboard', [RedirectController::class, 'dashboard'])->name('Admindashboard');
    Route::get('add/admins/page', [RedirectController::class, 'addAdminsPage'])->name('AddAdminsPage');
    Route::get('price/page', [RedirectController::class, 'pricePage'])->name('pricePage');
    Route::get('categories/page', [RedirectController::class, 'categoriesPage'])->name('categoriesPage');
    Route::get('colors/page', [RedirectController::class, 'colorsPage'])->name('colorsPage');
    Route::get('products/page', [RedirectController::class, 'productsPage'])->name('productsPage');
    Route::get('blogs/page', [RedirectController::class, 'blogsPage'])->name('blogsPage');
    Route::get('profile/page', [RedirectController::class, 'profilePage'])->name('profilePage');
    Route::get('orders/reply', [RedirectController::class, 'ordersReply'])->name('ordersReply');
    Route::get('orders/details/{order_code}', [RedirectController::class, 'orderDetails'])->name('orderDetails');
    Route::get('product/rating', [RedirectController::class, 'productRating'])->name('productRating');
    Route::get('blogs/comments', [RedirectController::class, 'blogComment'])->name('blogComment');

    //create
    Route::post('price/add', [CreateController::class, 'addPrice'])->name('addPrice');
    Route::post('category/add', [CreateController::class, 'addCategory'])->name('addCategory');
    Route::post('color/add', [CreateController::class, 'addColor'])->name('addColor');
    Route::post('product/add', [CreateController::class, 'addProduct'])->name('addProduct');
    Route::post('blog/add', [CreateController::class, 'addBlog'])->name('addBlog');
    Route::post('comment/reply', [CreateController::class, 'Reply'])->name('Reply');
    Route::post('price/confirmed',[CreateController::class,'priceConfirmed'])->name('priceConfirmed');

    //update
    Route::post('/update/role', [UpdateController::class, 'updateRole'])->name('updateRole');
    Route::post('update/price', [UpdateController::class, 'updatePrice'])->name('updatePrice');
    Route::post('update/category', [UpdateController::class, 'updateCategory'])->name('updateCategory');
    Route::post('update/color', [UpdateController::class, 'updateColor'])->name('updateColor');
    Route::post('update/product', [UpdateController::class, 'updateProduct'])->name('updateProduct');
    Route::post('/profile/update', [UpdateController::class, 'updateProfile'])->name('updateProfile');
    Route::post('/update-blog/{id}', [UpdateController::class, 'updateBlog'])->name('updateBlog');
    Route::get('/confirm/order/{order_code}', [UpdateController::class, 'comfirmOrders'])->name('comfirmOrders');
    Route::get('/denied/order/{order_code}', [UpdateController::class, 'deniedOrders'])->name('deniedOrders');

    //delete
    Route::delete('/product/{id}', [DeleteController::class, 'deleteProduct'])->name('deleteProduct');
    Route::delete('/blog/{id}', [DeleteController::class, 'deleteBlog'])->name('deleteBlog');
});
