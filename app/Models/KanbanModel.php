<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KanbanModel extends Model
{
    protected $table = 'kanban';
    protected $primaryKey = 'id'; //each id in kanban represent sub task relations with task_id

    protected $fillable = [
        'task_id',
        'name',
        'enum',
        'status',
        'created_at',
        'updated_at',
    ];

    public function task()
    {
        return $this->belongsTo(TaskModel::class, 'task_id');
    }
}
