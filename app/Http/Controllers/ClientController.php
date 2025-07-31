<?php

namespace App\Http\Controllers;

use App\Models\RevisionHistoryModel;
use App\Models\TaskModel;
use App\Services\TaskInterface;
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
        $taskChat = [];
        $task = [];
        $taskByUserNearDeadline = [];
        $user = Auth::user()->user_detail_id;
        try {
            $task = $this->taskService->getAllTask('in-progress', false);
            if (isEmpty($task)) {
                throw new ModelNotFoundException("Task not found", 404);
            }
            #if task deadline have more than one result get only one near the deadline
            if (count($task) > 1) {
                $taskByUserNearDeadline = $task->where('user_detail_id', $user)->sortBy('deadline')->first();
            } else {
                $taskByUserNearDeadline = $task->where('user_detail_id', $user)->first();
            }

            #get chat message based
            $taskChat = $this->methodServiceUtil->fetchMassageByTaskId($taskByUserNearDeadline->task_id);
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
        $data = [];
        try {
            $data = User::findOrFail(Auth::user()->id)
                ->with('UserDetail')
                ->first();
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ups! something went wrong: ' . $th->getMessage());
        }
        return view('client.profile', compact('data'));
    }

    /**
     * By click the save change button, profile will be updated
     **/
    public function updateProfile(Request $request)
    {
        $request->validate([
            'address' => 'max:255',
            'phone' => 'max:13' | 'numeric',
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
            $feedback = FeedBackModel::where('user_id', Auth::user()->id)->get();
            $task = $this->taskService->getAllTask('done', false);
            foreach ($task as $t) {
                $revision = RevisionHistoryModel::where('task_id', $t->task_id)
                    ->where('status', 'done')
                    ->get();
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

}
