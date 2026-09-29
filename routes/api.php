<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\Facades\DataTables;



Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Passport: token-authenticated CRUD (only admins may delete)
Route::middleware('auth:api')->group(function () {
    Route::apiResource('products', ProductController::class)->except('destroy');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])
        ->middleware('role:admin');
});

// Sanctum: session-authenticated data for the DataTables page
Route::middleware('auth:sanctum')->get('products-table', function () {
    return DataTables::of(Product::query())->make(true);
});

