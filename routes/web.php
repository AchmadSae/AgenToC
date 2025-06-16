<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;


/**
 * begin root route
 **/
Route::get('/', function () {
    return view('landing');
})->name('home');
Route::get('/join', function () {
    return view('auth.register')->with('isWorkerView', true);
})->name('join');
/**
 * end root route
 **/

Route::middleware(['auth'])->group(function () {
    /**
     * begin rout group for admin
     **/
    Route::prefix('admin')->middleware('admin')->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin_dashboard');

    });
    /**
     * end rout group for admin
     **/

    /**
     * begin root group for worker
     **/
    Route::prefix('worker')->middleware('worker')->group(function () {
        Route::get('/dashboard', [WorkerController::class, 'index'])->name('worker_dashboard')->name('worker_dashboard');
    });
    /**
     * end root group for worker
     **/

    /**
     * begin root group for customer
     **/
    Route::prefix('customer')->middleware('users')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'index'])->name('customer_dashboard')->name('customer_dashboard');
    });
    /**
     * end root group for customer
     **/
});


