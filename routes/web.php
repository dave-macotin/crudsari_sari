<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleItemController;
use App\Http\Controllers\StockInController;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('suppliers',  SupplierController::class);
Route::resource('categories', CategoryController::class);
Route::resource('products',   ProductController::class);
Route::resource('sales',      SaleController::class);
Route::resource('sale_items', SaleItemController::class);
Route::resource('stock_in',   StockInController::class);
