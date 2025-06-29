<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetailRolesModel extends Model
{
    protected $table = 'user_detail_roles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_detail_id',
        'role_id',
        'is_active',
        'created_at',
        'updated_at',
    ];
}
