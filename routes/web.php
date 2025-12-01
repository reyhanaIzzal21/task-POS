<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// route middleware group for admin

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [ProfileController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';
