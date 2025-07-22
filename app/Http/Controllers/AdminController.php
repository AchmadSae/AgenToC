<?php

namespace App\Http\Controllers;

use App\Models\TransactionsModel;
use App\Services\TaskInterface;
use App\Services\TransactionsInterface;
use App\Services\UserInterface;
use Illuminate\Http\Request;
use App\Models\GlobalParam;
use App\Models\RevisionHistoryModel;
use App\Models\TaskModel;
use App\Services\FeedBackInterface;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\PublicMethodeService;

class AdminController extends Controller
{
    protected $transactionsService;
    protected $userService;
    protected $taskService;
    protected $publicMethodeService;
    protected $feedbackService;

    public function __construct(
        TransactionsInterface $transactionsInterface,
        UserInterface $userInterface,
        TaskInterface $taskInterface,
        PublicMethodeService $publicMethodeService,
        FeedBackInterface $feedbackService
    ) {
        $this->publicMethodeService = $publicMethodeService;
        $this->transactionsService = $transactionsInterface;
        $this->userService = $userInterface;
        $this->taskService = $taskInterface;
        $this->feedbackService = $feedbackService;
    }
    /**
     * view  of register user (included unverified user), amount out of income and task almost get dateline
     * view reference dashboards/projects.html 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     * */
    public function index()
    {

        $allDoneTask = [];
        $allClient = [];
        $allTask = [];
        try {
            $allClient = $this->userService->getSpecifiedRole('user');
            $allTask = $this->taskService->getAllTask('in-progress', true);
            $allDoneTask = $this->transactionsService->getAllTransactionByTask('done');
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return view('admin.dashboard', compact('allClient', 'allTask'));
    }
    #begin transaction
    /**
     * view all the transactions (Paginate)
     * reference /widgets/tables.html <!--begin::Tables Widget 13-->
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     **/
    public function Transactions()
    {
        $data = [];
        try {
            //code...
            $data = TransactionsModel::orderBy('created_at', 'desc')->paginate(10);
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return view('admin.transactions', compact('data'));
    }

    /**
     * view transaction detail
     * reference apps/invoices/view/invoice-2.html
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     **/
    public function TransactionDetail($id)
    {

        $data = [];
        try {
            //code...
            $data = TransactionsModel::find($id);
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return view('admin.transaction-detail', compact('data'));
    }


    public function approvedPayment($id)
    {

        $data = [];
        try {
            //code...
            $data = $this->transactionsService->approvedPayment($id);
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        Alert::success('success', 'Payment Approved');
        return redirect()->route('transactions');
    }
    #end transaction

    #begin global parameter
    /**
     * add global parameter
     * reference /widgets/tables.html <!--begin::Tables Widget 13-->
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     **/
    public function addGlobalParam(Request $request)
    {
        $request->validate([
            'code' => 'required|is_unique:global_params.code',
            'value' => 'required',
        ]);
        $data = [];
        try {
            //code...
            $data = new GlobalParam();
            $data->name = $request->name;
            $data->value = $request->value;
            $data->save();
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return redirect()->route('admin.global-param');
    }


    /**
     * view all global parameters
     * reference /widgets/tables.html <!--begin::Tables Widget 13-->
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     **/
    public function GlobalParam()
    {
        $data = [];
        try {
            //code...
            $data = GlobalParam::all();
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return view('admin.global-param', compact('data'));
    }

    /**
     * request hit by ajax to add global parameter when modal show a form
     * reference /widgets/tables.html <!--begin::Tables Widget 13-->
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     **/
    public function addGlobalParamView(Request $request)
    {
        #get email current user
        $email = Auth::user()->email;
        $request->validate([
            'code' => 'required|is_unique:global_params.code',
            'value' => 'required',
        ]);

        try {
            //code...
            $data = new GlobalParam();
            $data->value = $request->value;
            $data->code = $request->code;
            $data->description = $request->description;
            $data->updated_by = $email;
            $data->save();
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return view('admin.global-param-add', compact('data'));
    }
    /**
     * request hit by ajax to add global parameter when modal show a form
     * reference /widgets/tables.html <!--begin::Tables Widget 13-->
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     **/
    public function updateGlobalParam(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|is_unique:global_params.code',
            'value' => 'required',
        ]);
        $data = [];
        try {
            //code...
            $userData = $this->publicMethodeService->getRoleNameAndUsername(Auth::user());
            $data = GlobalParam::find($id);
            $data->value = $request->value;
            $data->code = $request->code;
            $data->description = $request->description;
            $data->updated_by = $userData['username'];
            $data->save();
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return redirect()->route('admin.global-param');
    }
    #end global parameter

    #begin feedback
    /**
     * view all the feedback from user (list included carousel)
     * reference widgets/feeds.html <!--begin::Tickets-->
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     **/

    public function reviewers()
    {
        $data = [];
        try {
            //code...
            $data = $this->feedbackService->getAllFeedbacks();
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return view('admin.reviewers', compact('data'));
    }

    public function replyFeedback(Request $request, $id)
    {
        $request->validate([
            'message' => 'required',
        ]);
        $data = [];
        try {
            //code...
            $data = $this->feedbackService->getFeedbackById($id);
            if ($data) {
                $data->message = $request->message;
                $data->save();
                Alert::success('success', 'Feedback replied successfully');
            } else {
                Alert::error('error', 'Feedback not found');
            }
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return redirect()->route('feedback');
    }
    #end feedback

    #begin task
    /**
     * view list of all task
     * reference widgets/tables.html <!--begin::Tables Widget 13-->
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     **/
    public function tasks()
    {
        $data = [];
        try {
            //code...
            $data = TaskModel::orderBy('created_at', 'desc')->paginate(10);
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return view('admin.tasks', compact('data'));
    }

    /**
     * view detail of task (is have an revision => show the revision detail)
     * reference demo10/dashboards/projects.html (combined card and show the current revision if exist)
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     **/
    public function taskDetail($id)
    {
        $revision = [];
        $task = [];
        try {
            //code...
            $task = TaskModel::find($id);
            $isRevision = $this->taskService->isRevisionExist($id);
            if ($isRevision) {
                $revision = RevisionHistoryModel::where('task_id', $id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $revision = null;
            }
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return view('admin.task-detail', compact('task', 'revision'));
    }

    /**
     * update only the status of task
     * reference demo10/dashboards/projects.html (combined card and show the current revision if exist)
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     **/

    public function updateTask(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in-progress,done',
        ]);
        try {
            //code...
            $data = TaskModel::find($id);
            if ($data) {
                $data->status = $request->status;
                $data->save();
                Alert::success('success', 'Task Id ' . $id . ' status updated successfully');
            } else {
                Alert::error('error', 'Task not found');
            }
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return redirect()->route('tasks');
    }

    #begin assets
    /**
     * view all the assets (asstest of employees)
     * reference apps/user-management/users/list.html
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     **/
    public function employees()
    {
        $data = [];
        try {
            EmployeeModel::orderBy('created_at', 'desc')->paginate(10);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    #end assets
}
