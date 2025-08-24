<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DepartmentsModel;

class EmployeeModel extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'email',
        'phone_number',
        'department_id',
        'position',
        'is_active',
    ];

    public function Departments(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(DepartmentsModel::class, 'department_id', 'id');
    }
}
