<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationTrigger implements ShouldQueue
{
   use Dispatchable, InteractsWithSockets, SerializesModels;

    public String $userDetailId;
    public String $title;
    public String $content;

    public function __construct($userDetailId, $title, $content = null)
    {
        $this->userDetailId = $userDetailId;
        $this->title = $title;
        $this->content = $content;
    }
}
