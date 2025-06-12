<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_detail_id',
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


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
