<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Models\RevisionHistoryModel;
use App\Models\TaskModel;
use App\Services\TaskInterface;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MethodServiceUtil;
use App\Models\User;
use App\Services\UserInterface;
use App\Models\FeedBackModel;

use function PHPUnit\Framework\isEmpty;

class ClientController extends Controller
{
    protected TaskInterface $taskService;
    protected MethodServiceUtil $methodServiceUtil;

    protected UserInterface $userService;

    /**
     * view current product or task in-progress(can chat the worker(no attachment)
     * -> this view same like detail task from list of task)
     * calender set about due date off all task
     * @return mixed
     **/
    public function index()
    {
        $user = Auth::user()->user_detail_id;
        $taskByUserNearDeadline = [];
        try {
            $taskInDeadline = $this->taskService->getAllTask(Constant::TASK_STATUS_IN_PROGRESS, false);
            if (!isEmpty($taskInDeadline)) {
                  #if task deadline have more than one result get only one near the deadline
                  if (count($taskInDeadline) > 1) {
                      $taskByUserNearDeadline = $taskInDeadline->where('client_id', $user)->sortBy('deadline')->first();
                  } else {
                      $taskByUserNearDeadline = $taskInDeadline->where('client_id', $user)->first();
                  }
            }

            #get chat message based
            $taskChat = $this->methodServiceUtil->fetchMassageByTaskId($taskByUserNearDeadline->id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ups! something went wrong: ' . $th->getMessage());
        }
        return view('client.dashboard', ['taskByUser' => $taskByUserNearDeadline, 'chatHistory' => $taskChat]);
    }

    /**
     * view the profile of client and edit the profile
     * view reference /demo10/account/settings.html
     * @return mixed
     **/

    public function clientProfile()
    {
        try {
            $profile = User::findOrFail(Auth::user()->user_detail_id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ups! something went wrong: ' . $th->getMessage());
        }
        return view('client.profile', compact('profile'));
    }

    /**
     * By click the save change button, profile will be updated
     **/
    public function updateProfile(Request $request)
    {
        $request->validate([
            'address' => 'max:255',
            'profile_photo_path' => 'mimes:jpeg,jpg,png|max:2048',
            'phone' => 'max:13' | 'numeric',
            'email' => 'email',
            'postal_code' => 'max:5' | 'numeric',
            'credit_card' => 'max:16' | 'numeric',

        ]);

        try {
            $this->userService->updateUser($request->all(), 'client');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ups! something went wrong: ' . $th->getMessage());
        }
        Alert::success('success', 'Profile updated successfully');
        return redirect()->back();
    }

    /**
     * view history product(done), review and complain(done)
     **/
    public function history()
    {
          $revision = [];
          $task = [];
          $feedback = [];
          try {
                $taskDone = $this->taskService->getAllTask(Constant::TASK_STATUS_COMPLETED, false);
                $taskWorker = $taskDone->where('client_id', Auth::user()->user_detail_id);
                foreach ($taskWorker as $task) {
                      $feedback = FeedBackModel::where('task_id', $task->id)->get();
                      $revision = RevisionHistoryModel::where('task_id', $task->id)->get();
                }

          } catch (\Throwable $th) {
                return redirect()->back()->with('error', 'Ups! something went wrong: ' . $th->getMessage());
          }
          return view('client.history', compact('revision', 'task', 'feedback'));
    }

    /**
    * View all task and user can click the card of task for detail ( included the status of the project and show the chat if project still in-progress)
     * file:///D:/development/AgentC/demo10/pages/user-profile/projects.html
     * @return mixed
    **/
    public function tasksClient(){
          $allTasks = TaskModel::where('user_id', Auth::user()->id)->get();
          return view('client.tasks', compact('allTasks'));
    }

    /**
    * Detail tasks (show the sub tasks and show the chat if tasks in-progress)
     *
     * @return mixed
    **/

    public function detailTask($id){
          $taskChat = [];
          $task = TaskModel::findOrFail($id);
          $subTask = TaskModel::with(['detailTask'])->where('id', $id)->first();
          if ($task->status == 'in-progress') {
                $taskChat = $this->methodServiceUtil->fetchMassageByTaskId($task->id);
          }
          return view('client.detailTask', compact('task', 'subTask', 'taskChat'));
    }

    /**
    * complain task (will be added in button modal in card of task in-progress)
     * file:///D:/development/AgentC/demo10/apps/support-center/tickets/view.html
     * @return \Illuminate\Http\RedirectResponse
     **/

    public function revisionTaskClient(Request $request){
          $response =[];
          $userDetailId = Auth::user()->user_detail_id;
          $request->validate([
                'task_id' => 'required',
                'title' => 'required|max:100',
                'description' => 'required'
          ]);
          $data = $request->all();
          $data['user_detail_id'] = $userDetailId;
          try {
               $response = $this->taskService->storedTicketForRevision($data);
          }catch (\Throwable $e){
                Alert::error('Ups! something went wrong: ' . $e->getMessage());
                return redirect()->back();
          }
          Alert::success('success', 'Revision Ticket '.$response['id'].' successfully posted');
          return redirect()->back();
    }
    /**
    * posted feedback for done task the button rate will display when task done
    **/
    public function rateTaskClient(Request $request){
          $request->validate([
                'task_id' => 'required',
                'rate' => 'required',
                'comment' => 'required|max:255'
          ]);
          $isDone = TaskModel::findOrFail($request->task_id)->value('status');
          if($isDone == 'done'){
                $Feedback = new FeedbackModel();
                $Feedback->user_id = Auth::user()->user_detail_id;
                $Feedback->task_id = $request->task_id;
                $Feedback->comment = $request->comment;
                $Feedback->rating = $request->rate;
                $Feedback->save();
            Alert::success('success', 'Thanks For Your Feedback');
            return redirect()->back();
          }
          Alert::info('info', 'Your task still on going');
          return redirect()->back();
    }

    /**
    * get original file after task is done
     * click button done in detail task and download button will be show
    **/

    public function downloadAttachment($id){
          try {
                  $path = $this->taskService->downloadAttachment($id);
                  return Storage::download($path);
          }catch (\Throwable $th){
                alert()->error('File not allowed to download' . $th->getMessage());
                return redirect()->back();
          }
    }

}
