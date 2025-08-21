<?php

namespace App\Models\Messages;

use Illuminate\Database\Eloquent\Model;

class NotificationTmpModel extends Model
{
    protected $table = 'notification_tmp';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'is_read',
    ];
}
