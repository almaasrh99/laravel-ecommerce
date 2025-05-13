<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;




Route::get('/', [ProductController::class, 'index'])->name('welcome');

Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/search', [ProductController::class, 'search'])->name('product.search');



// Admin Products//

Route::middleware(['auth','verified' ,'isAdmin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/products', [AdminController::class, 'productList'])->name('dashboard.products');
    Route::get('/dashboard/products/add', [AdminController::class, 'productAdd'])->name('dashboard.products.create');
    Route::post('/dashboard/products', [AdminController::class, 'storeProduct'])->name('dashboard.products.store');
    Route::delete('/dashboard/products/{id}', [AdminController::class, 'deleteProduct'])->name('dashboard.products.delete');
    Route::get('/dashboard/products/{id}/edit', [AdminController::class, 'editProduct'])->name('dashboard.products.edit');
    Route::put('/dashboard/products/{id}', [AdminController::class, 'updateProduct'])->name('dashboard.products.update');

});

//Admin Orders//

Route::middleware(['auth','verified' ,'isAdmin'])->group(function () {
    Route::get('/dashboard/orders', [AdminController::class, 'listOrder'])->name('dashboard.orders');
    Route::get('/dashboard/orders/{id}', [AdminController::class, 'showOrder'])->name('dashboard.orders.show');
    // Route::delete('/dashboard/products/{id}', [AdminController::class, 'deleteOrders'])->name('dashboard.orders.delete');
   

});


Route::middleware('auth','verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'updateCartCount'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::match(['PUT', 'PATCH'], '/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');
});

Route::middleware(['auth'])->group(function () {
  Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
  Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.show');


});



require __DIR__.'/auth.php';
