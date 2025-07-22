<?php

namespace App\Models;

class EmployeeModel extends BaseModel
{
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'salary',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(DepartmentModel::class, 'department_id', 'department_id');
    }
}
