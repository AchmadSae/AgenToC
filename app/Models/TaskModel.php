<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DetailTaskModel;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'kanban_id',
        'client_id',
        'worker_id',
        'detail_task_id',
        'status',
        'acceptance_deadline_time',
        'deadline',
        'is_approved'
    ];

    public function detailTask(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DetailTaskModel::class, 'detail_task_id', 'id');
    }
    public function subTask(): TaskModel|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(KanbanModel::class, 'task_id');
    }

    public function chats(): TaskModel|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MessageModel::class, 'task_id');
    }

    public function revisionHistory(): TaskModel|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RevisionHistoryModel::class, 'task_id');
    }

    public function taskFiles(): TaskModel|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TaskFilesModel::class, 'task_id');
    }

    public function getTask($id)
    {
        return $this->belongsTo(DetailTaskModel::class, 'detail_task_id', 'id')->where('id', $id)->first();
    }




    /**
     * search by any field and value
     **/

    public function searchAny($field, $value): \LaravelIdea\Helper\App\Models\_IH_TaskModel_C|array
    {
        return $this->where($field, 'like', '%' . $value . '%')->get();
    }
}
