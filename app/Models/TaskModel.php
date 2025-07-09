<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DetailTaskModel;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'id';

    protected $fillable = [
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

    public function getTask($id)
    {
        return $this->belongsTo(DetailTaskModel::class, 'detail_task_id', 'id')->where('id', $id)->first();
    }
}
