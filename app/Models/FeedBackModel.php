<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedBackModel extends Model
{
    protected $table = 'feedback';
    protected $primaryKey = 'id';

    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
        'message',
        'rating',
    ];

    public function Task(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TaskModel::class, 'task_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
