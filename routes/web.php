<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::get('products', function () {
//     return view('products.index');
// });
Route::resource('products', ProductController::class);
Route::get('api/products', [ProductController::class, 'apiData'])->name('products.api');
Route::resource('users', UserController::class)->except(['create', 'show']);
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
