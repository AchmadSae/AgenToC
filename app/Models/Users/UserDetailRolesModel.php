<?php

namespace App\Models\Users;

use App\Models\RoleModel;
use Illuminate\Database\Eloquent\Model;

class UserDetailRolesModel extends Model
{
    protected $table = 'user_detail_roles';

    protected $fillable = [
        'role_id',
        'user_detail_id',
        'is_active'
    ];

    public function Role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RoleModel::class, 'role_id', 'id');
    }

    public function UserDetail(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserDetailModel::class, 'user_detail_id', 'user_detail_id');
    }

    public function User(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_detail_id', 'user_detail_id');
    }
}
