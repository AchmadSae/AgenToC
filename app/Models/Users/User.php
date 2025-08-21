<?php

namespace App\Models\Users;

use App\Models\MessageModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    protected $table = 'users';

    protected $fillable = [
        'user_detail_id',
        'username',
        'email',
        'password',
        'profile_photo_path',
        'email_verified_at',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function UserDetail(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserDetailModel::class, 'user_detail_id', 'user_detail_id');
    }

    public function messages(): hasMany
    {
        return $this->hasMany(MessageModel::class);
    }
}
