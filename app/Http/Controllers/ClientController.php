<?php

namespace App\Http\Controllers;

use App\Services\TaskInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use App\Services\MethodServiceUtil;

use function PHPUnit\Framework\isEmpty;

class ClientController extends Controller
{
    private $isValidTask;
    private $taskService;
    private $methodServiceUtil;


    public function __construct(TaskInterface $taskInterface, MethodServiceUtil $methodServiceUtil)
    {
        $this->isValidTask = [
            'title' => 'required|unique:tasks|max:255',
            'description' => 'required',
            'user_id' => 'required',
            'deadline' => 'required|date',
            'task_contract' => 'required',
            'required_skills' => 'required',
            'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ];

        $this->taskService = $taskInterface;
        $this->methodServiceUtil = $methodServiceUtil;
    }
    /**
     * view current product or task in-progress(can chat the worker(no attachment)
     * -> this view simmilar like detail task from list of task)
     * calender set about due date off all task
     * @return mixed
     **/
    public function index()
    {
        $taskChat = [];
        $task = [];
        $taskByUserNeadDeadline = [];
        $user = Auth::user()->user_detail_id;
        try {
            $task = $this->taskService->getAllTask('in-progress', false);
            if (isEmpty($task)) {
                throw new ModelNotFoundException("Task not found", 404);
            }
            #if task deadline have more than one result get only one near the deadline
            if (count($task) > 1) {
                $taskByUserNeadDeadline = $task->where('user_detail_id', $user)->sortBy('deadline')->first();
            } else {
                $taskByUserNeadDeadline = $task->where('user_detail_id', $user)->first();
            }

            #get chat message based
            $taskChat = $this->methodServiceUtil->fetchMassageByTaskId($taskByUserNeadDeadline->task_id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Ups! something went wrong: ' . $th->getMessage());
        }
        return view('client.dashboard', ['taskByUser' => $taskByUserNeadDeadline, 'chatHistory' => $taskChat]);
    }


    /**
     * @param $request
     * @return mixed
     **/
    public function createInquiry(Request $request)
    {
        $response = [];
        $valid = $request->validate($this->isValidTask);
        try {
            $response = $this->taskInterface->stored($valid);
        } catch (\Throwable $th) {
            return redirect()->back()->with('Ups! something went wrong', $th->getMessage());
        }
        return redirect()->route('client_dashboard')->with('success', 'Post Task Title' . $response['title'] . 'has been created');
    }

    /**
     * @param $id, $workerId
     * @return mixed
     **/

    public function binding($id, $workerId)
    {
        $response = $this->taskInterface->bindTask($id, $workerId);
        if (!$response) {
            throw new InternalErrorException("Error Processing Request", 500);
        }
        return redirect()->back()->with('success', 'Post Task has been assigned');
    }

    /**
     * @param $id
     * @return mixed
     **/

    public function approval($id)
    {
        $response = $this->taskInterface->approval($id);
        #decrease the coins
        if (!$response) {
            throw new ModelNotFoundException("Error Processing Request", 500);
        }
        return redirect()->back()->with('success', 'Post Task has been approved');
    }

    public function destroyTask($id)
    {
        $response = $this->taskInterface->deleteTask($id);
        if (!$response) {
            throw new ModelNotFoundException("Error Processing Request", 500);
        }
        return redirect()->back()->with('success', 'Post Task has been deleted');
    }
}
