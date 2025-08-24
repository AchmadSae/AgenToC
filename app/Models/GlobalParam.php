<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalParam extends Model
{
    protected $table = 'global_parameter';
    protected $fillable = [
        'code',
        'value',
        'description',
        'updated_by'
    ];
}
