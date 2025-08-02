<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Models\FeedBackModel;
use App\Models\GlobalParam;
use App\Models\RevisionHistoryModel;
use App\Models\TaskModel;
use App\Models\User;
use App\Services\MethodServiceUtil;
use App\Services\TaskInterface;
use App\Services\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\DB;

class WorkerController extends Controller
{
      protected TaskInterface $taskService;
      protected MethodServiceUtil $methodServiceUtil;
      protected UserInterface $userService;

      /**
      * view the incoming in progress task based worker_id and deadline
       * file:///D:/development/AgentC/demo10/pages/user-profile/projects.html
       *
      **/
    public function index()
    {
          $user = Auth::user()->user_detail_id;
          $taskByWorkerNearDeadline = [];
          try {
                $taskInDeadline = $this->taskService->getAllTask(Constant::TASK_STATUS_IN_PROGRESS, false);
                if (!isEmpty($taskInDeadline)) {
                      if (count($taskInDeadline) > 1) {
                            $taskByWorkerNearDeadline = $taskInDeadline->where('worker_id', $user)->sortBy('deadline')->first();
                      } else {
                            $taskByWorkerNearDeadline = $taskInDeadline->where('worker_id', $user)->first();
                      }
                }
                $taskChat = $this->methodServiceUtil->fetchMassageByTaskId($taskByWorkerNearDeadline->id);
          }catch(\Throwable $th){
                return redirect()->back()->with('error', $th->getMessage());
          }
          return view('worker.dashboard', compact('taskByWorkerNearDeadline', 'taskChat'));
    }

    /**
    * view the profile of worker and edit by click the save button
     * view reference /demo10/account/settings.html
     * @return mixed
    **/

    public function workerProfile(){
          try {
                $profile = User::findOrFail(Auth::user()->user_detail_id);
          }catch(\Throwable $th){
                return redirect()->back()->with('error', 'Ups! something went wrong: ' . $th->getMessage());
          }
          return view('worker.profile', compact('profile'));
    }

    public function updateProfileWorker(Request $request){
          $request->validate([
                'address' => 'max:255',
                'profile_photo_path' => 'mimes:jpeg,jpg,png|max:2048',
                'phone' => 'max:13' | 'numeric',
                'email' => 'email',
                'skills' => 'max:255',
                'postal_code' => 'max:5' | 'numeric',
                'credit_card' => 'max:16' | 'numeric',
          ]);
          try {
                $this->userService->updateUser($request->all(), 'worker');
          }catch(\Throwable $th){
                return redirect()->back()->with('error', 'Ups! something went wrong: ' . $th->getMessage());
          }
          Alert::success('Profile updated successfully!');
          return redirect()->back();
    }

      /**
       * view history product(done),
       **/
      public function history()
      {
            $revision = [];
            $task = [];
            $feedback = [];
            try {
                  $taskDone = $this->taskService->getAllTask(Constant::TASK_STATUS_COMPLETED, false);
                  $taskWorker = $taskDone->where('worker_id', Auth::user()->user_detail_id);
                  foreach ($taskWorker as $task) {
                        $feedback = FeedBackModel::where('task_id', $task->id)->get();
                        $revision = RevisionHistoryModel::where('task_id', $task->id)->get();
                  }

            } catch (\Throwable $th) {
                  return redirect()->back()->with('error', 'Ups! something went wrong: ' . $th->getMessage());
            }
            return view('worker.history', compact('revision', 'task', 'feedback'));
      }

      /**
       * worker finished the task and countdown review in client side enable
       * can't revision is countdown over
       *
       * @throws \Throwable
       */

      public function doneTaskWorker($id){
            $taskModel = TaskModel::findOrFail($id)->lockForUpdate()->first();
            DB::transaction(function () use ($taskModel) {
                  $taskModel->status = Constant::TASK_STATUS_COMPLETED;
                  $taskModel->save();
            }, Constant::DB_ATTEMPT);
      }

}
