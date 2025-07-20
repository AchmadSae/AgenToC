<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Models\GlobalParam;
use App\Services\TransactionsInterface;
use ErrorException;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\ToSweetAlert;

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
        $data['password'] = GlobalParam::where('code', 'DEFAULT_PASS')->first()->value;
        try {
            //code...
            $response = $this->transactionService->checkout($data);
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        #receipt waiting payment
        return view('receipt', compact('response'));
    }


}
