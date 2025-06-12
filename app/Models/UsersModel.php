<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'user_detail_id',
        'name',
        'email',
        'password',
        'email_verified_at',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_detail()
    {
        return $this->belongsTo(UserDetailModel::class, 'user_detail_id', 'id');
    }


    /**
     * Get the user_detail record associated with the user
     **/
    public function getAllUsers()
    {
        return $this->with('user', 'user_detail')->get();
    }
    /**
     * Find User by email
     **/
    public function findUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }


    /**
     *  Find corresponding users 
     **/
    public function findUser($anything)
    {
        $columns = Schema::getColumnListing('users');
        $query = static::query();

        $query->where(function ($q) use ($anything, $columns) {
            foreach ($columns as $column) {
                $q->orWhere($column, 'like', '%' . $anything . '%');
            }
        });

        return $query->get();
    }
}
