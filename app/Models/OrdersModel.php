<?php

namespace App\Models;

use App\Models\Tasks\TaskModel;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class OrdersModel extends Model
{
    protected $table = 'orders';
    protected $keyType = 'string';
    public $incrementing = false;

    #email we set for user_id
    protected $fillable = [
        'order_id',
        'order_number',
        'invoice_id',
        'task_id',
        'user_detail_id',
        'product_code',
        'product_type',
        'payment_method',
        'quantity',
        'total_price',
        'status',
    ];
}
