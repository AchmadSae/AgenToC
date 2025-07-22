<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TaskModel;
use App\Models\User;

class FeedBackModel extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
        'rating',
    ];

    public function task()
    {
        return $this->belongsTo(TaskModel::class, 'task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
