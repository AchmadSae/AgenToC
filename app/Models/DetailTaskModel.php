<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTaskModel extends Model
{
    protected $table = 'detail_tasks';

    protected $fillable = [
          'title',
        'description',
        'price',
        'required_skills',
        'task_contract',
    ];
}
