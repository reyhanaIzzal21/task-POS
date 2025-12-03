<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return view('user.pages.welcome');
});


// route middleware group for admin

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [ProfileController::class, 'indexAdmin'])->name('dashboard.admin');
        // products
        Route::resource('products', ProductController::class);

        // sales
        Route::resource('sales', SaleController::class);

        // customers
        Route::resource('customers', CustomerController::class);

        // cashier
        Route::get('cashier', [CashierController::class, 'index'])->name('cashier.index');
        Route::post('cashier/checkout', [CashierController::class, 'checkout'])->name('cashier.checkout');
        Route::get('/cashier/receipt/{id}', [CashierController::class, 'receipt'])->name('cashier.receipt');
    });
});

require __DIR__ . '/auth.php';
