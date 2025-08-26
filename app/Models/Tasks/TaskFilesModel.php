<?php

namespace App\Models\Tasks;


use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks\TaskModel;

class TaskFilesModel extends Model
{
      protected $table = 'task_file';
      protected $primaryKey = 'id';
      protected $fillable = [
            'task_id',
            'file_path',
            'file_name',
            'file_type',
            'mime_type',
            'file_size',
      ];

      public function Task(): \Illuminate\Database\Eloquent\Relations\BelongsTo
      {
            return $this->belongsTo(TaskModel::class, 'task_id', 'id');
      }
}
