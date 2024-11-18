<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CreateController;
use App\Http\Controllers\Admin\DeleteController;
use App\Http\Controllers\Admin\UpdateController;
use App\Http\Controllers\Admin\RedirectController;


Route::middleware('admin')->prefix('admin')->group(function () {
    //redirects
    Route::get('/dashboard', [RedirectController::class, 'dashboard'])->name('Admindashboard');
    Route::get('add/admins/page',[RedirectController::class, 'addAdminsPage'])->name('AddAdminsPage');
    Route::get('price/page',[RedirectController::class, 'pricePage'])->name('pricePage');
    Route::get('categories/page',[RedirectController::class, 'categoriesPage'])->name('categoriesPage');
    Route::get('products/page',[RedirectController::class, 'productsPage'])->name('productsPage');
    Route::get('blogs/page',[RedirectController::class, 'blogsPage'])->name('blogsPage');

    //create
    Route::post('price/add',[CreateController::class, 'addPrice'])->name('addPrice');
    Route::post('category/add',[CreateController::class, 'addCategory'])->name('addCategory');
    Route::post('product/add',[CreateController::class, 'addProduct'])->name('addProduct');
    Route::post('blog/add', [CreateController::class, 'addBlog'])->name('addBlog');

    //update
    Route::post('/update/role', [UpdateController::class, 'updateRole'])->name('updateRole');
    Route::post('update/price', [UpdateController::class, 'updatePrice'])->name('updatePrice');
    Route::post('update/category', [UpdateController::class, 'updateCategory'])->name('updateCategory');
    Route::post('update/product', [UpdateController::class, 'updateProduct'])->name('updateProduct');


    Route::delete('/product/{id}', [DeleteController::class, 'deleteProduct'])->name('deleteProduct');
});
