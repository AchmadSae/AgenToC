<?php

namespace App\Http\Controllers;

use App\Helpers\Log;
use Illuminate\Http\Request;
use App\Models\TaskModel;
use App\Services\TaskImpl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    private $role;
    private $validatonRule;
    private $localDate;
    protected $taskService;

    public function __construct(TaskImpl $taskImpl)
    {
        $this->taskService = $taskImpl;
    }
    public function index()
    {
        if ($this->role == 'client') {
            /**
             * show the task posted by client
             * @param $id
             **/
            $allTask = TaskModel::where('user_id', Auth::user()->id)->get();
            return view('client.task', compact('allTask'));
        }

        if ($this->role == 'worker') {
            /**
             * show the all task posted
             * @return view
             **/
            $allTask = TaskModel::with('detailTask')->get();
            return view('worker.task', compact('allTask'));
        }
    }

    /**
     * post the task
     * @param Request $request
     * @return view
     **/

    public function postTask(Request $request)
    {
        $data = $request->all();
        $response = $this->taskService->postTask($data);
        Log::browser($response);
        return redirect()->back()->with('success', 'Task has been posted');
    }


    public function approval($value, $id): RedirectResponse
    {
        $task = TaskModel::find($id);
        $task->status = $value;
        $task->save();
        #decrease the coins
        return redirect()->back()->with('success', 'Post Task has been approved');
    }

    public function bindTask($id): bool
    {
        DB::transaction(function () use ($id) {
            $task = TaskModel::where('id', $id)->lockForUpdate()->first();
            $task->worker_id = Auth::user()->email;
        }, 2);
        return true;
    }

    /**
     * delete the task role admin permission
     * @param $id
     * @return view
     **/

    public function deleteTask($id)
    {
        DB::transaction(function () use ($id) {
            $task = TaskModel::where('id', $id)->lockForUpdate()->first();
            $task->delete();
        }, 2);
        return view('worker.task')->with('success', 'Task has been deleted');
    }
}
