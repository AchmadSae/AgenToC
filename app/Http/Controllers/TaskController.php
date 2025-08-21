<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Helpers\Log;
use Illuminate\Http\Request;
use App\Models\TaskModel;
use App\Services\Impl\TaskImpl;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\GlobalParam;

class TaskController extends Controller
{
    protected $globalDBattempts;
    protected $role;
    protected $localDate;
    protected $taskService;
    protected $validationRule;
    public function __construct(TaskImpl $taskImpl)
    {
        $this->globalDBattempts = GlobalParam::get('DB_ATTEMPTS')->value;
        $this->taskService = $taskImpl;
        $this->validationRule = [
            'client_id' => 'required',
            'deadline' => 'required|date',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'task_contract' => 'required|string',
            'price' => 'required|numeric|min:0',
            'required_skills' => 'required|string|max:255',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
    public function index()
    {
        if ($this->role == 'client') {
            /**
             * show the task posted by client
             * @param $email
             * @return view
             **/
            $allTask = TaskModel::where('user_id', Auth::user()->email)->get();
            return view('client.task', compact('allTask'));
        }

        if ($this->role == 'worker') {
            /**
             * show the all task posted
             * @return view
             **/
            $allTask = TaskModel::with('DetailTask')->status(Constant::TASK_PENDING)->get();
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
        $data = $request->validate($this->validationRule);
        $data = $request->all();
        try {
            //code...
            $response = $this->taskService->stored($data);
        } catch (QueryException $th) {
            return redirect()->back()->with('Ups! something went wrong', $th->getMessage());
        }
        #stg debug
        Log::browser($response);
        return redirect()->back()->with('success', 'Task title = ' . $response['title'] . ' has been posted successfully');
    }

    /**
     * approval task
     *
     * @param string $value
     * @param string $id
     * @return RedirectResponse
     **/
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
        }, $this->globalDBattempts);
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
        }, $this->globalDBattempts);
        return view('worker.task')->with('success', 'Task has been deleted');
    }
}
