<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Model;

class DetailTaskModel extends Model
{
    protected $table = 'task_detail';
    protected $primaryKey = 'id';

    protected $keyType = 'string';

    protected $fillable = [
          'id',
          'title',
        'description',
          'task_type',
        'price',
        'task_contract',
        'required_skills',
    ];
}
