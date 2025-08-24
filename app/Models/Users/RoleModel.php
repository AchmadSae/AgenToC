<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'role_id',
        'role_name',
    ];
}
