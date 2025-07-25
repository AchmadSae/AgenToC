<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('task-chat.{taskId}', function ($user, $taskId) {

    return true; // You can add logic here to check if the user has access to the task
});
