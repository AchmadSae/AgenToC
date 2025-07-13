<?php

namespace App\Http\Controllers;

use App\Services\TaskInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskModel;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class CustomerController extends Controller
{
    private $isValidTask;
    private $taskInterface;


    public function __construct(TaskInterface $taskInterface)
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

        $this->taskInterface = $taskInterface;
    }
    /**
     * All task posted by customer
     * @return mixed
     **/
    public function index()
    {
        $user = Auth::user()->email;
        $data = TaskModel::findOrFail($user)->get();
        return view('client.dashboard', ['data' => $data]);
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
