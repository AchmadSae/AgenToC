<?php

use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\TransactionsController;

Broadcast::channel('task-chat.{taskId}', function ($user, $taskId) {

    return true; // You can add logic here to check if the user has access to the task
});

Route::post('/api/checkout', [TransactionsController::class, 'checkout'])->name('checkout');
