<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;

// Redirect base URL to /products
Route::redirect('/', '/products');

// Public access (any authenticated user can view products)
Route::middleware('auth')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
});

//Admin-only access (only admins can create, edit, delete, sell, and add quantity)
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('products/{product}/sell', [ProductController::class, 'sell'])->name('products.sell');
    Route::post('products/{product}/add-quantity', [ProductController::class, 'addQuantity'])->name('products.addQuantity');
});

// Auth routes
Auth::routes();

// Home route after login
Route::get('/home', function () {
    return redirect('/products');
});




