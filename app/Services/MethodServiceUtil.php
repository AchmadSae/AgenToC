<?php

namespace App\Services;

use App\Events\ChatTaskSent;
use App\Helpers\Constant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\MessageModel;
use App\Events\NotificationSent;

class MethodServiceUtil
{
    public function getRoleNameAndUsername($user): array
    {
        $name = $user->name ?? '';
        $role_name = '';
        $response = DB::table('user_detail_roles')
            ->join('roles', 'roles.role_id', '=', 'user_detail_roles.role_id')
            ->where('user_detail_roles.user_detail_id', $user->user_detail_id)
            ->where('user_detail_roles.is_active', true)
            ->value('roles.role_name');
        if ($response === null) {
            throw new \Exception('Role not found for user: ' . $user->user_detail_id);
        }
        $role_name = $response;

        return [
            'role_name' => $role_name,
            'username' => $name
        ];
    }

    public function isPermissionExist($email, $typeAdmin): bool
    {
        $flag = false;
        switch ($typeAdmin) {
            case Constant::ADMIN_CEO_LEVEL:
                $flag = User::where('email', $email)
                    ->join('employees', 'employees.email', '=', 'users.email')
                    ->where('employees.position', Constant::ADMIN_CEO_LEVEL)
                    ->exists();
                break;
            case Constant::ADMIN_MANAGER_LEVEL:
                $flag = User::where('email', $email)
                    ->join('employees', 'employees.email', '=', 'users.email')
                    ->where('employees.position', Constant::ADMIN_MANAGER_LEVEL)
                    ->exists();
                break;
            case Constant::ADMIN_REGULAR_LEVEL:
                $flag = User::where('email', $email)
                    ->join('employees', 'employees.email', '=', 'users.email')
                    ->where('employees.position', Constant::ADMIN_REGULAR_LEVEL)
                    ->exists();
                break;
            default:
                $flag = false;
                break;
        }
        return $flag;
    }

    public function fetchMassageByTaskId($taskId): \Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\_IH_MessageModel_C
    {
        return MessageModel::where('task_id', $taskId)
            ->with('user')
            ->get();
    }

    public function sendMessage($data): void
    {
        MessageModel::create([
            'task_id' => $data['task_id'],
            'user_id' => $data['user_id'],
            'message' => $data['message']
        ]);

        broadcast(new ChatTaskSent($data['message'], $data['task_id']))->toOthers();
    }

    /**
     * broadcast notification
     **/
    public function sendNotification($data)
    {
        $notification = $data['text'];
        $userId = $data['userId'];

        broadcast(new NotificationSent($notification, $userId))->toOthers();
    }

      public function saveFile($files): array
      {

            $filePaths = [];
            foreach ($files as $file) {
                  $fileName = time().'_'.$file->getClientOriginalName();
                  $path = $file->storeAs('assets/media/task', $fileName, 'public');

                  $filePaths[] = '/storage/'.$path;
            }

            return ['file_paths' => $filePaths];
      }
}
