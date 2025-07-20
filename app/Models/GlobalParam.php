<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalParam extends Model
{
    protected $table = 'global_parameter';
    protected $fillabel = [
        'code',
        'value',
        'description'
    ];
}
