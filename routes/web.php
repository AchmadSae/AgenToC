<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionsController;

Route::get('/test', function () {
    return view('test');
})->name('test');

/**
 * begin root route
 **/
Route::get('/', [TransactionsController::class, 'checkout'])->name('home');
#checkout
Route::get('/checkout', [TransactionsController::class, 'checkout'])->name('checkout');
#feedback
Route::post('/feedback', [TransactionsController::class, 'feedback'])->name('feedback');

Route::controller(AuthController::class)->group(function () {
    Route::get('signin/{flag}', 'showLoginForm')->name('sign-in');
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->name('logout');
    Route::get('signup/{flag}', 'showRegistrationForm')->name('sign-up');
    Route::post('register', 'register')->name('register');
    // Email verification
    Route::get('email/verify/{id}/{hash}', 'verifyEmail')->name('verification.verify');
    Route::post('email/resend', 'resendVerification')->name('verification.resend');
});

/**
 * end root route
 **/


Route::middleware(['oAuth'])->controller(AuthController::class)->group(function () {
    // Password reset
    Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    Route::post('password/reset', 'reset')->name('password.update');

    /**
     * begin rout group for admin
     **/
    Route::prefix('admin')->middleware('admin')->controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('admin_dashboard');
        Route::get('/global-param', 'GlobalParam')->name('global-param');
        Route::post('/global-param/add', 'addGlobalParam')->name('add-global-param');
        Route::post('/global-param/update/{id}', 'updateGlobalParam')->name('update-global-param');
        Route::get('/feedback', 'reviewers')->name('feedback');
        Route::post('/feedback/{id}', 'replyFeedback')->name('reply-feedback');

        #task (show all the task on going and can see the detail complain revision)
        Route::prefix('task')->controller(AdminController::class)->group(function () {
            Route::get('/', 'tasks')->name('tasks');
            Route::get('/detail/{id}', 'taskDetail')->name('task-detail');
            #update the status of task
            Route::post('/update/{id}', 'updateTask')->name('update-task');
        });


        #transaction
        Route::get('/transactions', 'Transactions')->name('transactions');
        Route::get('/transaction-detail/{id}', 'TransactionDetail')->name('transaction-detail');
        Route::get('/approved-payment/{id}', 'approvedPayment')->name('approved-payment');

        #assets
        Route::prefix('assets')->controller(AdminController::class)->group(function () {
            Route::get('/employees', 'employees')->name('employees');
            Route::post('/employees/add', 'addEmployee')->name('add-employee');
            Route::post('/employees/update/{id}', 'updateEmployee')->name('update-employee');

            #financial (coming soon)
            Route::get('/equity', 'equity')->name('equity');
            Route::post('/equity/add', 'addEquity')->name('add-equity');
            Route::post('/equity/update/{id}', 'updateEquity')->name('update-equity');
        });
    });
    /**
     * end rout group for admin
     **/


    /**
     * begin root group for customer
     **/
    Route::prefix('client')->middleware('users')->group(function () {
        #index in dashboard wil be show current post product / task has been order
        Route::get('/dashboard', [ClientController::class, 'index'])->name('client_dashboard');
        Route::get('/profile', [ClientController::class, 'profile'])->name('client_profile');
        Route::post('/profile/update({id})', [ClientController::class, 'updateProfile'])->name('update-profile');
        Route::get('history', [ClientController::class, 'history'])->name('history');
        Route::prefix('task')->controller(ClientController::class)->group(function () {
            #this will be included the chat and kanban status off project
            Route::get('/detail/{id}', 'detailTask')->name('detail_task');
            Route::post('/chat/{id}', 'postTask')->name('post_task');
            Route::post('/complain/{id}', 'complainTask')->name('complain_task');
            Route::post('/rate/{id}', 'rateTask')->name('rate_task');
            Route::get('task/attachments/{id}', 'attachments')->name('attachments');
        });

        #kanban

    });
    /**
     * end root group for customer
     **/

    /**
     * begin root group for worker
     **/
    Route::prefix('worker')->middleware('worker')->group(function () {
        #show the news inquiries(card) and all the inquiries(table) 
        Route::get('/dashboard', [WorkerController::class, 'index'])->name('worker_dashboard');
        Route::get('/profile', [WorkerController::class, 'profile'])->name('client_profile');
        Route::post('/profile/update({id})', [WorkerController::class, 'updateProfile'])->name('update-profile');
        Route::get('history', [WorkerController::class, 'history'])->name('history');
        #Task done can't complain with time limit response from client
        Route::post('/done/task({id})', [WorkerController::class, 'task'])->name('done-task');
        Route::prefix('complains')->controller(WorkerController::class)->group(function () {
            Route::get('/({id})', 'complains')->name('complains');
            Route::get('/update/{id}', 'updateComplain')->name('update-complain');
        });
        // Route::prefix('kanban-board')->controller(KanbanController::class)->group(function () {
        //     Route::view('/', 'KanbanBoard.Index')->name('kanban-board');
        //     Route::get('get-all', 'getItems')->name('get-all-items');
        //     Route::post('store', 'store')->name('store');
        //     Route::post('update', 'update'->name('update-kanban'));
        //     Route::post('reorder', 'reorder')->name('reorder-kanban');
        //     Route::post('delete', 'destroy')->name('delete-kanban');
        // });
    });
    /**
     * end root group for worker
     **/
});
