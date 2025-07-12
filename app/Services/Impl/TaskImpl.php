<?php

namespace App\Services;

use App\Helpers\Constant;
use App\Models\DetailTaskModel;
use App\Models\TaskModel;
use App\Repositories\TaskInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\GenerateId;
use App\Models\GlobalParam;
use App\Models\UserDetailModel;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class TaskImpl implements TaskInterface
{
    private $validationRule;
    private $localDate;

    public function __construct()
    {
        $this->validationRule = [
            'title' => 'required|unique:tasks|max:255',
            'description' => 'required',
            'user_id' => 'required',
            'deadline' => 'required|date',
            'task_contract' => 'required',
            'required_skills' => 'required',
            'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ];
        $t = Carbon::now();
        $this->localDate = Carbon::parse($t)
            ->setTimezone('Asia/Jakarta')
            ->toDateTimeString();
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
        $isValidate = $data->validate($this->validationRule);
        $typeTask = $data->task_type;

        if (!$isValidate) {
            throw new BadRequestException('Bad Request');
        }
        #prepare data 
        $task = [
            'id' => GenerateId::generateWithDate(Constant::ID_TASK),
            'detail_task_id' => GenerateId::generateWithDate(Constant::ID_TASK_DETAIL),
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

        try {
            //code...
            TaskModel::create($task);
            DetailTaskModel::create($detailTask);

            if ($typeTask == Constant::TASK_INQUIRY) {
                $cost = GlobalParam::find(Constant::TASK_INQUIRY)->value;
                DB::transaction(function () use ($user, $cost) {
                    $userBalance = UserDetailModel::where('user_detail_id', $user->id)->lockforupdate()->first();
                    $coins = $userBalance->balance_coins - $cost;
                    $user->balance_coins = $coins;
                    $user->save();
                }, 2);
            }
        } catch (\Throwable $th) {
            throw new InternalErrorException('Request Failed Check Balance or Request: ' . $th, http_response_code(500));
        }
        $response = [
            'id' => $task['id'],
            'detail_task_id' => $detailTask['id'],
            'title' => $task['title'],
            'deadline' => $task['deadline'],
            'created_at' => $task['created_at'],
        ];

        return $response;
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
        $task->status = true;
        $task->save();
        return true;
    }

    public function bindTask($id, $workerId): bool
    {
        DB::transaction(function () use ($id, $workerId) {
            $task = TaskModel::where('id', $id)->lockForUpdate()->first();
            $task->worker_id = $workerId;
            $task->save();
        }, 2);
        return true;
    }

    public function deleteTask($id): bool
    {
        $detailTaskId = TaskModel::where('id', $id)->first()->detail_task_id;
        TaskModel::where('id', $id)->delete();
        DetailTaskModel::where('id', $detailTaskId)->delete();

        return true;
    }
}
