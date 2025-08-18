<?php

namespace App\Services\Impl;

use App\Helpers\Constant;
use App\Helpers\LogConsole;
use App\Models\DetailTaskModel;
use App\Models\KanbanModel;
use App\Models\TaskModel;
use App\Models\TicketRevisionModel;
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
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class TaskImpl implements TaskInterface
{
    protected string $localDate;

    protected mixed $globalDbAttempts;
      private TaskInterface $taskService;

      public function __construct()
    {
        $this->globalDbAttempts = GlobalParam::where('code', '=', Constant::DB_ATTEMPT)->value('value');
        $t = Carbon::now();
        $this->localDate = Carbon::parse($t)
            ->setTimezone('Asia/Jakarta')
            ->toDateTimeString();
    }

      /**
       * @pram string $workerId
       * @param string|null $userId
       * @return void
       *
       * @throws \Throwable
       */
    public function coinsBalanceByApproved($workerId = null, string $userId = null, bool $isPostTicket = false): void
    {
          $costTicketUser = GlobalParam::where('code', '=', Constant::GAS_USER_TICKET)->value('value');
        $costUser = GlobalParam::Where('code', Constant::GAS_USER)->value('value');
        $costWorker = GlobalParam::Where('code', Constant::GAS_WORKER)->value('value');
        if (!$isPostTicket) {
              DB::transaction(function () use ($userId, $costTicketUser) {
                    $client = UserDetailModel::where('user_detail_id', $userId)->lockForUpdate()->first();
                    $client->balance_coins -= $costTicketUser;
                    $client->save();
              }, $this->globalDbAttempts);
        }else{
              DB::transaction(function () use ($workerId, $userId, $costUser, $costWorker) {
                  $worker = UserDetailModel::where('user_detail_id', $workerId)->lockForUpdate()->first();
                  $client = UserDetailModel::where('user_detail_id', $userId)->lockForUpdate()->first();

                  // Assuming you want to increase the worker's balance by a certain amount
                  $worker->balance_coins -= $costWorker;
                  $client->balance_coins -= $costUser;

                  $worker->save();
                  $client->save();
              }, $this->globalDbAttempts);
        }
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
            'attachment_request' => $data->attachment_request,
            'task_type' => $typeTask,
        ];

        TaskModel::create($task);
        DetailTaskModel::create($detailTask);
          return [
              'id' => $task['id'],
              'detail_task_id' => $detailTask['id'],
              'title' => $task['title'],
              'deadline' => $task['deadline'],
              'created_at' => $task['created_at'],
          ];
    }


      /**
       * @throws \Throwable
       */
      public function editTask($id, $data): bool
    {
        $task = TaskModel::find($id)->lockForUpdate()->first();
        DB::transaction(function () use ($task, $data) {
              $task->update($data);
        }, $this->globalDbAttempts);
        return true;
    }

      /**
       * approval task
       *
       * @param string $value
       * @param string $id
       * @return bool
       *
       * @throws \Throwable
       */
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
        if ($status == Constant::TASK_STATUS_IN_PROGRESS && $isDeadline) {
            $now = Carbon::parse($this->localDate);
            $tomorrow = $now->copy()->addDay();

            return  TaskModel::where('status', $status)
                ->whereBetween('deadline', [$now, $tomorrow])
                ->get();
        }

          return TaskModel::orderBy('created_at', 'desc')->get();
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

      public function storedTicketForRevision($data): array
      {
            $statusTask = TaskModel::find($data['task_id'])->status;
            $acceptance_deadline_time = TaskModel::find($data['task_id'])->acceptance_deadline_time;
            $ticketId = GenerateId::generateId($data['ticket_id'], false);
            $ticketCoins = GlobalParam::where("code", "=", Constant::GAS_USER_TICKET)->value("value");
            $coins = UserDetailModel::where('user_detail_id', $data->user_detail_id)->value('balance_coins');
            if ($coins == 0) {
                  return [
                        'status' => 'error',
                        'message' => "You need at least  < .$ticketCoins coins",
                  ];
            }
            if($statusTask != Constant::TASK_STATUS_COMPLETED OR $acceptance_deadline_time > Carbon::now()) {
                  return [
                        'status' => 'error',
                        'message' => "Your task is not completed Or Passed the response time",
                  ];
            }

            try {
                  $Task = TaskModel::find($data['task_id'])->lockForUpdate()->first();
                  $Task->status = Constant::TASK_STATUS_REVISION;
                  $Task->save();
                  TicketRevisionModel::create(
                        [
                              'id' => $ticketId,
                              'task_id' => $data->task_id,
                              'title' => $data->title,
                              'description' => $data->description,
                              'attachment' => $data->attachment,
                        ]
                  );
                  $this->coinsBalanceByApproved(null, $data->user_detail_id, true);
            } catch (\throwable $e) {
                  LogConsole::browser($e->getMessage(), "Internal Error");
            }

            return [
                  'status' => 'success',
                  'ticket_id' => $ticketId,
                  'task_id' => $data->task_id,
            ];
      }

    public function downloadAttachment($id): string
    {
        $detailTaskId = TaskModel::where('id', $id)->first()->detail_task_id;
        $isDoneTask = TaskModel::where('id', $detailTaskId)->value('status');
        if ($isDoneTask != Constant::TASK_STATUS_APPROVED){
              throw new BadRequestException('Task still in progress');
        }
          return DetailTaskModel::where('id', $detailTaskId)->value('attachment')->first();
    }

      /**
       * @throws \Throwable
       */
      public function doneTask($id)
      {
            $timeDueDateCompleted = Carbon::now()->addDays(7);
            $taskModel = TaskModel::findOrFail($id)->lockForUpdate()->first();
            $allStatusSubTask = KanbanModel::where('task_id', $taskModel->id)->get();
            $this->taskService->doneTask($id);
            foreach ($allStatusSubTask as $subTask) {
                  if ($subTask != Constant::SUBTASK_STATUS_DONE) {
                        throw new BadRequestException('Task still in progress');
                  }
            }
            DB::transaction(function () use ($timeDueDateCompleted, $taskModel) {
                  $taskModel->status = Constant::TASK_STATUS_COMPLETED;
                  $taskModel->acceptance_deadline_time = $timeDueDateCompleted;
                  $taskModel->save();
            }, Constant::DB_ATTEMPT);
            return $taskModel->id;
      }
}
