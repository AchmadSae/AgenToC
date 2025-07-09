<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTaskModel extends Model
{
    protected $table = 'detail_tasks';

    protected $fillable = [
        'description',
        'attachment',
        'price',
        'skill_required',
        'task_contract',
    ];
}
