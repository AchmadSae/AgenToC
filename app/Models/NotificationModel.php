<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    protected $table = 'notification_tmp';

    public $fillable = [
        'user_id',
        'title',
        'message',
        'is_read',
    ];
}
