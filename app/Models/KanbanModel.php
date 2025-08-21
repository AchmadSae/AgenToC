<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KanbanModel extends Model
{
    protected $table = 'kanbans';
    protected $primaryKey = 'id'; //each id in kanban represent sub task relations with task_id

    protected $fillable = [
        'task_id',
        'name',
        'status',
        'order'
    ];

    public function Task(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TaskModel::class, 'task_id', 'id');
    }
}
