<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ticket_revision extends Model
{
    protected $table = 'ticket_revisions';
    protected $fillable = [
          'task_id',
          'title',
          'description',
          'status',
          'attachment',
    ];
    public function task(): BelongsTo
    {
        return $this->belongsTo(TaskModel::class, 'task_id');
    }
}
