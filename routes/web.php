<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionsController;

// File Upload Route

Route::get('/test', function () {
    return view('test');
})->name('test');

/**
 * begin root route
 **/
Route::get('/', [LandingController::class, 'index'])->name('landing');
#checkout
Route::get('/checkout', [TransactionsController::class, 'checkout'])->name('checkout');
Route::post('/checkout/submit', [TransactionsController::class, 'submitCheckout'])->name('checkout.submit');


Route::controller(AuthController::class)->group(function () {
    Route::get('signing/{flag}', 'showLoginForm')->name('sign.in')->defaults('flag', 'user');
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->name('logout');
    Route::get('signup/{flag}', 'showRegistrationForm')->name('sign.up')->defaults('flag', 'user');
    Route::post('register', 'register')->name('register');

    #Google
      Route::get('/auth/google', 'googleAuth')->name('google');
      Route::get('/auth/google/callback/', 'googleAuthCallback')->name('google.callback');
    # Email verification
    Route::get('email/verify/{id}/{hash}', 'verifyEmail')->name('verification.verify');
    Route::post('email/resend', 'resendVerification')->name('verification.resend');
      #Password reset
      Route::post('password/reset', 'showRequestForm')->name('show-pass.request');
      Route::post('password/email', 'sendResetLinkEmail')->name('link.email');
      Route::get('password/reset/', 'showResetForm')->name('password.reset');
      Route::post('password/new', 'reset')->name('password.update');
});

/**
 * end root route
 **/


Route::middleware(['oAuth'])->group(function () {
    #begin rout broadcast
    Broadcast::channel('task.{taskId}', function ($user, $taskId) {
        return $user->tasks()->where('tasks.id', $taskId)->exists();
    });
    Broadcast::channel('user.{userId}', function ($user, $userDetailId) {
        return (string) $user->user_detail_id === (string) $userDetailId;
    });
    #chat
      Route::post('/chat/send', [CommandController::class, 'sendChat'])->name('chat.send');



    /**
     * begin rout group for admin
     **/
    Route::prefix('admin')->middleware('admin')->controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('admin.dashboard');
        Route::get('/global-param', 'GlobalParam')->name('global.param');
        Route::post('/global-param/add', 'addGlobalParam')->name('add.global.param');
        Route::post('/global-param/update/{id}', 'updateGlobalParam')->name('update.global.param');
        Route::get('/feedback', 'reviewers')->name('feedback');
        Route::post('/feedback/{id}', 'replyFeedback')->name('reply.feedback');

        #task (show all the task on going and can see the detail complain revision)
        Route::prefix('task')->controller(AdminController::class)->group(function () {
            Route::get('/', 'tasks')->name('tasks');
            Route::get('/detail/{id}', 'taskDetail')->name('task.detail');
            #update the status of task
            Route::post('/update/{id}', 'updateTask')->name('update.task');
        });


        #transaction
        Route::get('/transactions', 'Transactions')->name('transactions');
        Route::get('/transaction-detail/{id}', 'TransactionDetail')->name('transaction.detail');
        Route::get('/approved-payment/{id}', 'approvedPayment')->name('approved-payment');

        #assets
        Route::prefix('assets')->controller(AdminController::class)->group(function () {
            Route::get('/employees', 'employees')->name('employees');
            Route::post('/employees/add', 'addEmployee')->name('add.employee');
            Route::post('/employees/update/{id}', 'updateEmployee')->name('update.employee');

            #financial (coming soon)
            Route::get('/equity', 'equity')->name('equity');
            Route::post('/equity/add', 'addEquity')->name('add.equity');
            Route::post('/equity/update/{id}', 'updateEquity')->name('update.equity');
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
        Route::get('/dashboard', [ClientController::class, 'index'])->name('client.dashboard');
        Route::get('/profile', [ClientController::class, 'clientProfile'])->name('client.profile');
        Route::post('/profile/update({id})', [ClientController::class, 'updateProfile'])->name('update.profile');
        Route::get('history', [ClientController::class, 'history'])->name('history');
        Route::prefix('task')->controller(ClientController::class)->group(function () {
            #this will be included the chat and kanban status off project when click the detail of project
            Route::get('/', 'tasksClient')->name('tasks_client');
            Route::get('/detail/{id}', 'detailTask')->name('detail.task');
            Route::post('/revision/{id}', 'revisionTaskClient')->name('revision.task.clients');
            Route::post('/rate/{id}', 'rateTaskClient')->name('rate.task');
            Route::get('/download/{id}', 'downloadAttachment')->name('download.>attachments');
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
        Route::get('/dashboard', [WorkerController::class, 'index'])->name('worker.dashboard');
        Route::get('/profile', [WorkerController::class, 'workerProfile'])->name('client.profile');
        Route::post('/profile/update({id})', [WorkerController::class, 'updateProfileWorker'])->name('update.profile');
        Route::get('history', [WorkerController::class, 'historyWorker'])->name('history');
        #Task done client cant create ticket revision based  time limit response from client
        Route::prefix('task')->controller(WorkerController::class)->group(function () {
              Route::get('/', 'tasksWorker')->name('tasks.worker');
              Route::post('/done/{id}', 'doneTaskWorker')->name('done.task');
              Route::post('/start', 'startTaskWorker')->name('start.task');
              Route::get('/detail/{id}', 'detailTask')->name('detail.task.worker');
        });
        // https://github.com/ERaufi/LaravelProjects/blob/main/app/Http/Controllers/KanbanController.php
         Route::prefix('kanban-board')->controller(KanbanController::class)->group(function () {
             Route::view('/', 'Workers.KanbanBoard')->name('kanban.board');
             Route::post('reorder', 'reorder')->name('reorder.kanban');
             Route::post('delete', 'destroy')->name('delete.kanban');
         });
    });
    /**
     * end root group for worker
     **/
});
