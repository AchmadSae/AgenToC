<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetailModel extends Model
{
    protected $table = 'user_detail';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'skills',
        'tag_line',
        'address_detail',
        'phone_number',
        'postal_code',
        'credit_number',
        'balance_coins',
    ];
}
