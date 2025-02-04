<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\WarehouseTypeController;

Route::resource('customers', CustomerController::class);
Route::resource('products', ProductController::class);
Route::resource('warehouses', WarehouseController::class);
Route::resource('customer-types', CustomerTypeController::class);
Route::resource('product-types', ProductTypeController::class);
Route::resource('warehouse-types', WarehouseTypeController::class);