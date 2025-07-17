<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/**
 * begin::root auth
 **/

// Auth routes
Route::get('signin/{flag}', [AuthController::class, 'showLoginForm'])->name('sign-in');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('signup/{flag}', [AuthController::class, 'showRegistrationForm'])->name('sign-up');
Route::post('register', [AuthController::class, 'register'])->name('register');
// Email verification
Route::get('email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::post('email/resend', [AuthController::class, 'resendVerification'])->name('verification.resend');

/**
 * end::root auth
 **/

/**
 * begin root route
 **/
Route::get('/', function () {
    return view('landing');
})->name('home');
/**
 * end root route
 **/
Route::get('/test', function () {
    return view('test');
})->name('test');



Route::middleware(['oAuth'])->group(function () {
    // Password reset
    Route::get('password/reset', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [AuthController::class, 'reset'])->name('password.update');

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
        Route::get('/dashboard', [WorkerController::class, 'index'])->name('worker_dashboard');
    });
    /**
     * end root group for worker
     **/

    /**
     * begin root group for customer
     **/
    Route::prefix('client')->middleware('users')->group(function () {
        Route::get('/dashboard', [CustomerController::class, 'index'])->name('client_dashboard');
        Route::get('/task', [CustomerController::class, 'index'])->name('view_task');
        Route::post('/task/post', [CustomerController::class, 'postTask'])->name('post_task');
    });
    /**
     * end root group for customer
     **/
});
