<?php

namespace App\Util;

use App\Events\ChatTaskSent;
use App\Helpers\Constant;
use App\Models\OrdersModel;
use App\Models\ProductsModel;
use App\Models\Tasks\TaskModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\MessageModel;

class MethodServiceUtil
{
      /**
       * @throws \Exception
       */
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

            // Convert single file to array for consistent processing
            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                if (is_string($file)) {
                    $filePaths[] = $file;
                    continue;
                }

                $fileName = time().'_'.$file->getClientOriginalName();

                $directory = public_path('assets/media/task');
                if (!is_dir($directory)) {
                      mkdir($directory, 0777, true);
                }

                $file->move($directory, $fileName);

                $fileName = time().'_'.$file->getClientOriginalName();
                $filePaths[] = '/assets/media/task/'.$fileName;
            }

            return [
                'file_paths' => $filePaths
            ];
      }

      public function getReceipt($id): ?array
      {
            $order = OrdersModel::where('order_id', $id)->first();
            $task = TaskModel::select('task_type', 'task_contract', 'deadline')
                  ->join('task_detail', 'tasks.task_detail_id', '=', 'task_detail.id')
                  ->where('tasks.task_id', $order->task_id)
                  ->first();
            $product = ProductsModel::select('products.*', 'product_groups.*')
                  ->join('product_groups', 'products.product_group_code', '=', 'product_groups.code')
                  ->where('product_code', $order->product_code)
                  ->first();
            $user = \App\Models\Users\User::select('users.*', 'user_detail.*')
                  ->join('user_detail', 'users.user_detail_id', '=', 'user_detail.user_detail_id')
                  ->where('user_detail.user_detail_id', $order->user_detail_id)
                  ->first();
            $status = $task && $product && $user;
            if (!$status) {
                  return null;
            }
            return [
                  'order' => $order,
                  'task' => $task,
                  'product' => $product,
                  'user' => $user
            ];
      }
}
