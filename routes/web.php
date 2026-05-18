<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleItemController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('suppliers',  SupplierController::class);
Route::resource('categories', CategoryController::class);
Route::resource('products',   ProductController::class);
Route::resource('sales',      SaleController::class);
Route::resource('sale_items', SaleItemController::class);
Route::resource('stock_in',   StockInController::class);

// Report Routes (using Database Views)
Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
Route::get('/reports/sales', [ReportController::class, 'salesSummary'])->name('reports.sales_summary');
Route::get('/reports/receipt/{sale_id}', [ReportController::class, 'receipt'])->name('reports.receipt');
