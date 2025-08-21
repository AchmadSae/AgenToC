<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevisionHistoryModel extends Model
{
    protected $table = 'revision_history';
    protected $primaryKey = 'id';

    protected $fillable = [
        'task_id',
        'changes',
          'description',
        'attachment',
          'status'
    ];

    public function Task(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TaskModel::class, 'task_id', 'id');
    }

    public function getChangesAttribute($value)
    {
        return json_decode($value, true);
    }
}
