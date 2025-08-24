<?php

namespace App\Models\Users;


use Illuminate\Database\Eloquent\Model;

class UserDetailModel extends Model
{
    protected $table = 'user_detail';

    protected $fillable = [
        'user_detail_id',
        'full_name',
        'skills',
        'tag_line',
        'address_detail',
        'phone_number',
        'postal_code',
        'credit_number',
        'balance_coins',
    ];
}
