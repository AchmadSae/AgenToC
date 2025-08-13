<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskFilesModel extends Model
{
      protected $table = 'task_file';

      protected $fillable = [
            'task_id',
            'file_name',
            'file_path',
            'file_type',
            'mime_type',
            'file_size',
      ];
}
