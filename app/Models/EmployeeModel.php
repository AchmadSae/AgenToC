<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DepartmentsModel;

class EmployeeModel extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'position',
        'is_active',
    ];

    public function department()
    {
        return $this->belongsTo(DepartmentsModel::class, 'department_id', 'department_id');
    }
}
