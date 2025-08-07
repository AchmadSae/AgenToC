<?php

namespace App\Events;

use App\Models\TaskModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Console\View\Components\Task;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatTaskSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public String $message;
    public String $taskId;

    public String $userDetailId;

    public function __construct($message, $taskId, $sender)
    {
        $this->message = $message;
        $this->taskId = $taskId;
        $this->userDetailId = $sender;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('task-chat.' . $this->taskId),
        ];
    }
}
