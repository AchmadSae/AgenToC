<?php

namespace App\Models;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageModel extends Model
{

    protected $table = 'tasks_chats_tmp';
    protected $primaryKey = 'id';
    protected $fillable = [
        'task_id',
        'user_id',
        'message',
    ];

    public function Task(): BelongsTo
    {
        return $this->belongsTo(TaskModel::class, 'task_id', 'id');
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_detail_id');
    }
}
