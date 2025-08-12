<?php

namespace App\Listeners;

use App\Events\NotificationTrigger;
use App\Models\NotificationModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\NotificationSent;

class SendNotificationListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationTrigger $event): void
    {
        NotificationModel::create([
            'user_id' => $event->userDetailId,
            'title' => $event->title,
            'content' => $event->content
        ]);

        broadcast(new NotificationSent($event->title, $event->userDetailId))->toOthers();
    }
}
