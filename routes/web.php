<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/get-products', [ProductController::class, 'getProducts'])->name('products.get_products');
Route::post('/add-products', [ProductController::class, 'addProducts'])->name('products.add_products');
Route::post('/edit-products', [ProductController::class, 'addProducts'])->name('products.edit_products');
