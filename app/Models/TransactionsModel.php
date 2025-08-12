<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionsModel extends Model
{
    protected $table = 'transactions';

    #email we set for user_id
    protected $fillable = [
        'user_id',
        'product_id',
        'task_id',
        'product_type',
        'payment_method',
        'quantity',
        'total_price',
        'status',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'email');
    }

    public function task(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TaskModel::class, 'task_id');
    }
}
