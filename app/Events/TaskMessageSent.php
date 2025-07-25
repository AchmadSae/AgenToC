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

class TaskMessageSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $task;
    /**
     * Create a new event instance.
     */
    public function __construct(TaskModel $chat)
    {
        $this->task = $chat->load('user', 'task');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('task-chat.' . $this->task->id),
        ];
    }
}
