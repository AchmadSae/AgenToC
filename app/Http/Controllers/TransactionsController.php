<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Models\GlobalParam;
use App\Models\TaskFileModel;
use App\Services\TransactionsInterface;
use ErrorException;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\ToSweetAlert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransactionsController extends Controller
{

    protected $transactionService;
    protected $checkoutDataValidationRule;

    public function __construct(TransactionsInterface $transactionsInterface)
    {
        $this->transactionService = $transactionsInterface;

        $this->checkoutDataValidationRule = [
            'id_user' => 'required|email',
            'role' => 'required',
            'id_product' => 'required',
            'total_price' => 'required',
        ];
    }

    public function checkout(Request $request)
    {
        $response = [];
        #validation
        $request->validate($this->checkoutDataValidationRule);
        $data = $request->all();
        #make default password

    }

      /**
       * Handle checkout submit with files sent via FormData as files[]
       * Expects: optional task_id (string) to attach files to an existing task
       * @throws \Throwable
       */
    public function submitCheckout(Request $request)
    {
          $response = [];
        // Validate files if present
        $request->validate([
              'email' => 'required|email',
            'description' => 'required',
            'task_id' => 'nullable|string',
            'files' => 'nullable|array',
            'files.*' => 'file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt',
        ]);
        $data = $request->all();
          $data['password'] = GlobalParam::where('code', 'DEFAULT_PASS')->first()->value;
          try {
                //code...
                $response[] = $this->transactionService->checkout($data);
          } catch (\Throwable $th) {
                Alert::error('error', 'Failed checkout, check your request');
                return redirect()->back();
          }
          if ($request->wantsJson()) {
                return response()->json($response);
          }
          #receipt waiting payment
          return view('receipt', compact('response'));

    }


}
