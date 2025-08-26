<?php

namespace App\Models\Tasks;


use App\Models\KanbanModel;
use App\Models\MessageModel;
use App\Models\RevisionHistoryModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks\DetailTaskModel;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'kanban_id',
        'client_id',
        'worker_id',
        'task_detail_id',
        'status',
        'acceptance_deadline_time',
        'deadline',
        'is_approved'
    ];

/* <<<<<<<<<<<<<<  ✨ Windsurf Command ⭐ >>>>>>>>>>>>>>>> */
    /**
     * Detail task relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
/* <<<<<<<<<<  978ea972-cfce-4004-92c3-3654fb304f09  >>>>>>>>>>> */
    public function DetailTask(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DetailTaskModel::class, 'task_detail_id', 'id');
    }


    public function getTask($id)
    {
        return $this->belongsTo(DetailTaskModel::class, 'detail_task_id', 'id')->where('id', $id)->first();
    }

}
