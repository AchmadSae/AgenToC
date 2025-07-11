<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KanbanModel extends Model
{
    protected $table = 'kanban';
    protected $primaryKey = 'id';

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
