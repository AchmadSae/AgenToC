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
        'deadline',
        'is_approved'
    ];

    public function detailTask()
    {
        return $this->belongsTo(DetailTaskModel::class, 'detail_task_id', 'id');
    }
    public function kanban()
    {
        return $this->hasMany(KanbanModel::class, 'task_id');
    }

    public function revisionHistory()
    {
        return $this->hasMany(RevisionHistoryModel::class, 'task_id');
    }

    public function getTask($id)
    {
        return $this->belongsTo(DetailTaskModel::class, 'detail_task_id', 'id')->where('id', $id)->first();
    }




    /**
     * search by any field and value
     **/

    public function searchAny($field, $value)
    {
        return $this->where($field, 'like', '%' . $value . '%')->get();
    }
}
