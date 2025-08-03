<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Models\FeedBackModel;
use App\Models\GlobalParam;
use App\Models\KanbanModel;
use App\Models\RevisionHistoryModel;
use App\Models\TaskModel;
use App\Models\User;
use App\Services\KanbanInterface;
use App\Services\MethodServiceUtil;
use App\Services\TaskInterface;
use App\Services\UserInterface;
use Carbon\Carbon;
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

      protected KanbanInterface $kanbanService;

      /**
      * view the incoming in progress and task who have revision inquiry task based worker_id and deadline
       * file:///D:/development/AgentC/demo10/pages/user-profile/projects.html
       *
      **/
    public function index()
    {
          $user = Auth::user()->user_detail_id;
          $taskByWorkerNearDeadline = [];
          try {
                $taskInDeadline = $this->taskService->getAllTask(Constant::TASK_STATUS_IN_PROGRESS, false);
                $incomingNewestRevision = $this->taskService->getAllTask(Constant::TASK_STATUS_REVISION, false);
                if (!isEmpty($taskInDeadline) AND !isEmpty($incomingNewestRevision)) {
                      if (count($taskInDeadline) > 1 OR count($incomingNewestRevision) > 1) {
                            $taskByWorkerNearDeadline = $taskInDeadline->where('worker_id', $user)->sortBy('deadline')->first();
                            $incomingNewestRevision = $incomingNewestRevision->where('worker_id', $user)->sortBy('acceptance_deadline_time')->last();
                      } else {
                            $taskByWorkerNearDeadline = $taskInDeadline->where('worker_id', $user)->first();
                      }
                }
                $taskChat = $this->methodServiceUtil->fetchMassageByTaskId($taskByWorkerNearDeadline->id);
          }catch(\Throwable $th){
                return redirect()->back()->with('error', $th->getMessage());
          }
          return view('worker.dashboard', compact('taskByWorkerNearDeadline', 'taskChat', 'incomingNewestRevision'));
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
       * view history all task revision and feedback,
       **/
      public function historyWorker()
      {
            $revision = [];
            $feedback = [];
            try {
                  $tasks = TaskModel::with('details')->get();
                  $taskWorker = $tasks->where('worker_id', Auth::user()->user_detail_id);
                  foreach ($taskWorker as $task) {
                        $feedback = FeedBackModel::where('task_id', $task->id)->get();
                        $revision = RevisionHistoryModel::where('task_id', $task->id)->get();
                  }

            } catch (\Throwable $th) {
                  return redirect()->back()->with('error', 'Ups! something went wrong: ' . $th->getMessage());
            }
            return view('worker.history', compact('revision', 'tasks', 'feedback'));
      }

      /**
       * worker finished the task and countdown review in client side enable
       * can't revision is countdown over
       *
       * @throws \Throwable
       */

      public function doneTaskWorker($id){
            $timeDueDateCompleted = Carbon::now()->addDays(7);
            $taskModel = TaskModel::findOrFail($id)->lockForUpdate()->first();
            DB::transaction(function () use ($timeDueDateCompleted, $taskModel) {
                  $taskModel->status = Constant::TASK_STATUS_COMPLETED;
                  $taskModel->acceptance_deadline_time = $timeDueDateCompleted;
                  $taskModel->save();
            }, Constant::DB_ATTEMPT);
      }

      /**
       * Worker click the accepted task open and added subtask for kanban
       * the card have modal button to accepted and show the form to fill the subtask for kanban
       * @return mixed
       * direct view to kanban
       * <input type="text" name="subtask[]" />
       * <input type="text" name="subtask[]" />
       **/

      public function startTaskWorker(Request $request){
            $countSubTask = $request->countSubTask;
            $subtasks = [];
            if ($countSubTask == 0) {
                  Alert::warning('Subtask is required!');
            }
            foreach ($request->subtask as $sub) {
                  $subtasks[] = [
                        'kanban_id' => $request->kanban_id,
                        'name'      => $sub
                  ];
            }
            try {
                  KanbanModel::insert($subtasks);
            }catch(\Throwable $th) {
                  Alert::error('Ups! something went wrong: ' . $th->getMessage());
                  return redirect()->back();
            }
            Alert::success('Subtask started!');
            return redirect()->route('kanban-board');
      }

      /**
       * View all task and worker can click the card of task for detail ( included the status of the project and show the chat if project still in-progress)
       * file:///D:/development/AgentC/demo10/pages/user-profile/projects.html
       * @return mixed
       **/

      public function tasksWorker(){
            $allTasks = TaskModel::where('user_id', Auth::user()->user_detail_id)->paginate(6);
            return view('worker.tasks', compact('allTasks'));
      }

}
