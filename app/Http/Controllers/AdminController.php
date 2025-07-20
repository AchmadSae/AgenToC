<?php

namespace App\Http\Controllers;

use App\Models\TransactionsModel;
use App\Services\TaskInterface;
use App\Services\TransactionsInterface;
use App\Services\UserInterface;
use Illuminate\Http\Request;
use App\Models\GlobalParam;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    protected $transactionsService;
    protected $userService;

    protected $taskService;

    public function __construct(TransactionsInterface $transactionsInterface, UserInterface $userInterface, TaskInterface $taskInterface)
    {
        $this->transactionsService = $transactionsInterface;
        $this->userService = $userInterface;
        $this->taskService = $taskInterface;
    }
    public function index()
    {
        #view  off register user (included unverified user), amount out of income and task almost get dateline
        #view reference file:///D:/development/AgentC/demo10/dashboards/projects.html
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

    public function Transactions()
    {
        $data = [];
        try {
            //code...
            $data = TransactionsModel::all();
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return view('admin.transactions', compact('data'));
    }

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
        return redirect() - route('transactions');
    }

    /**
     * Global Param
     * @return mixed
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

    public function updateGlobalParam(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|is_unique:global_params.code',
            'value' => 'required',
        ]);
        $data = [];
        try {
            //code...
            $data = GlobalParam::find($id);
            $data->value = $request->value;
            $data->code = $request->code;
            $data->description = $request->description;
            $data->save();
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        return redirect() - route('admin.global-param');
    }

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
        return redirect() - route('admin.global-param');
    }



}
