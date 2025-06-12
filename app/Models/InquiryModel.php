<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InquiryModel extends Model
{
    protected $table = 'inquiry';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = [
        'id',
        'client_id',
        'worker_id',
        'detail_task_id',
        'status',
        'deadline',
        'is_approved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id', 'id');
    }

    public function detail_task()
    {
        return $this->belongsTo(TaskDetailModel::class, 'detail_task_id', 'id');
    }

    /**
     * Get All Inquiry
     **/

    public function getAllInquiry()
    {
        return $this->with('user', 'worker', 'detail_task')->get();
    }

    /**
     * Find Inquiry By Id
     **/

    public function findInquiryById($id)
    {
        return $this->with('user', 'worker', 'detail_task')->find($id);
    }

    /**
     * find coresponding inquiry
     **/

    public function findInquiry($anything)
    {
        $columns = Schema::getColumnListing('inquiry');
        $query = static::query();

        $query->where(function ($q) use ($anything, $columns) {
            foreach ($columns as $column) {
                $q->orWhere($column, 'like', '%' . $anything . '%');
            }
        });

        return $query->get();
    }
}
