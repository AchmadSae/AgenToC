<?php

namespace App\Services\Impl;

use App\Helpers\Constant;
use App\Models\DetailTaskModel;
use App\Models\TaskModel;
use App\Services\TaskInterface;
use Carbon\Carbon;
use App\Models\User;
use App\Models\RevisionHistory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Helpers\GenerateId;
use App\Models\GlobalParam;
use App\Models\RevisionHistoryModel;
use App\Models\UserDetailModel;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class TaskImpl implements TaskInterface
{
    protected $localDate;

    protected $timeDateLine;
    protected $globalDBattempts;

    public function __construct()
    {
        $this->globalDBattempts = GlobalParam::get('DB_ATTEMPTS')->value;

        $t = Carbon::now();
        $this->localDate = Carbon::parse($t)
            ->setTimezone('Asia/Jakarta')
            ->toDateTimeString();
    }

    /**
     * @pram string $workerId
     * @param string $userId
     * @return void
     **/
    public function coinsBalanceByApproved($workerId = null, $userId = null): void
    {
        $costUser = GlobalParam::Where('code', Constant::GAS_USER);
        $costWorker = GlobalParam::Where('code', Constant::GAS_WORKER);
        DB::transaction(function () use ($workerId, $userId, $costUser, $costWorker) {
            $worker = UserDetailModel::where('user_detail_id', $workerId)->lockForUpdate()->first();
            $client = UserDetailModel::where('user_detail_id', $userId)->lockForUpdate()->first();

            // Assuming you want to increase the worker's balance by a certain amount
            $worker->balance_coins -= GlobalParam::where('code', $costUser)->first()->value;
            $client->balance_coins -= GlobalParam::where('code', $costWorker)->first()->value;

            $worker->save();
            $client->save();
        }, $this->globalDBattempts);
    }

    /**
     * create task
     * 
     * @param object $data
     * @return array
     **/
    public function stored($data): array
    {
        $user = UserDetailModel::where('user_detail_id', $data->user_detail_id)->first();
        $typeTask = $data->task_type;
        #prepare data 
        $task = [
            'id' => GenerateId::generateId(Constant::ID_TASK, false),
            'slug' => GenerateId::generateSlug($data->title),
            'detail_task_id' => GenerateId::generateId(Constant::ID_TASK_DETAIL, true),
            'title' => $data->title,
            'user_id' => $data->email,
            'deadline' => $data->deadline,
            'created_at' => $this->localDate,
        ];

        $detailTask = [
            'id' => $task['detail_task_id'],
            'description' => $data->description,
            'task_contract' => $data->task_contract,
            'price' => $data->price,
            'required_skills' => $data->required_skills,
            'attachment' => $data->attachment,
            'task_type' => $typeTask,
        ];

        TaskModel::create($task);
        DetailTaskModel::create($detailTask);
        $response = [
            'id' => $task['id'],
            'detail_task_id' => $detailTask['id'],
            'title' => $task['title'],
            'deadline' => $task['deadline'],
            'created_at' => $task['created_at'],
        ];

        return $response;
    }



    public function editTask($id, $data): bool
    {

        $task = TaskModel::find($id);
        if (!$task) {
            throw new BadRequestException('Task not found');
        }

        $task->title = $data['title'] ?? $task->title;
        $task->deadline = $data['deadline'] ?? $task->deadline;
        $task->save();

        $detailTask = DetailTaskModel::find($task->detail_task_id);
        if (!$detailTask) {
            throw new InternalErrorException('Detail task not found');
        }

        $detailTask->description = $data['description'] ?? $detailTask->description;
        $detailTask->task_contract = $data['task_contract'] ?? $detailTask->task_contract;
        $detailTask->price = $data['price'] ?? $detailTask->price;
        $detailTask->required_skills = $data['required_skills'] ?? $detailTask->required_skills;
        if (isset($data['attachment'])) {
            $detailTask->attachment = $data['attachment'];
        }
        return $detailTask->save();
    }

    /**
     * approval task
     * 
     * @param string $value
     * @param string $id
     * @return bool
     **/
    public function approval($id): bool
    {
        $task = TaskModel::find($id);
        $client = User::where('email', $task->user_id)->user_detail_id->first();
        $worker = User::where('id', $task->worker_id)->user_detail_id->first();

        if (!$task || !$client || !$worker) {
            throw new BadRequestException('Task or User not found');
        }
        $task->status = true;
        $task->save();
        $this->coinsBalanceByApproved($worker, $client);
        return true;
    }

    public function bindTask($id, $workerId): bool
    {
        $rs = DB::transaction(function () use ($id, $workerId) {
            $task = TaskModel::where('id', $id)->lockForUpdate()->first();
            $task->worker_id = $workerId;
            $task->save();
        }, $this->globalDBattempts);
        if ($rs == null) {
            return false;
        }
        return true;
    }

    public function deleteTask($id): bool
    {
        $detailTaskId = TaskModel::where('id', $id)->first()->detail_task_id;
        $rs = DB::transaction(function () use ($id, $detailTaskId) {
            TaskModel::where('id', $id)->delete();
            DetailTaskModel::where('id', $detailTaskId)->delete();
        }, $this->globalDBattempts);

        if ($rs == null) {
            return false;
        }

        return true;
    }

    public function getAllTask($status = 'done', $isDeadline = false): Collection
    {
        $task = [];
        if ($status == 'in-progress' && $isDeadline) {
            $now = Carbon::parse($this->localDate);
            $tomorrow = $now->copy()->addDay();

            $task = TaskModel::where('status', $status)
                ->whereBetween('deadline', [$now, $tomorrow])
                ->get();
        }

        $task = TaskModel::where('status', $status)->get();
        return $task;
    }

    public function revision($data): array
    {
        $revision = [
            'task_id' => $data['task_id'],
            'changes' => $data['changes'],
            'changed_by' => $data['changed_by'],
            'attachment' => $data['attachment'] ?? null,
        ];

        $revisionHistory = RevisionHistoryModel::create($revision);
        return [
            'id' => $revisionHistory->id,
            'task_id' => $revisionHistory->task_id,
            'changes' => $revisionHistory->changes,
            'changed_by' => $revisionHistory->changed_by,
            'attachment' => $revisionHistory->attachment,
        ];
    }

    public function isRevisionExist($taskId): bool
    {
        $revision = RevisionHistoryModel::where('task_id', $taskId)
            ->orderBy('created_at', 'desc')
            ->first();
        if ($revision == null || !$revision->exists()) {
            throw new BadRequestException('Revision not found for task: ' . $taskId);
        }
        return true;
    }
}
