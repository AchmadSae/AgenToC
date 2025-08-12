<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskFileModel extends Model
{
      protected $table = 'task_files';
      protected $primaryKey = 'id';

      protected $fillable = [
            'task_id',
            'path',
            'original_name',
            'size',
            'mime_type',
            'disk',
            'file_map'
      ];
}
