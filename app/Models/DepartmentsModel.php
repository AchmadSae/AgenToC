<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentsModel extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'name',
        'location',
        'manager_id',
        'description',
    ];
}
