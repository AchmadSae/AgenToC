<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    protected $table = 'assets';

    protected $fillable = [
        'name',
        'type',
        'path',
    ];

    /**
     * Get the asset's full path.
     *
     * @return string
     */
    public function getFullPathAttribute()
    {
        return asset($this->path);
    }
}
