<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Models\GlobalParam;
use App\Services\MethodServiceUtil;
use App\Services\TransactionsInterface;
use ErrorException;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\ToSweetAlert;

class TransactionsController extends Controller
{

    protected TransactionsInterface $transactionService;

    protected MethodServiceUtil $methodService;

    public function checkout(Request $request)
    {
        $response = [];
        #validation
        $request->validate([
              'email' => 'required|email',
              'name' => 'required',
              'product_code' => 'required',
              'title' => 'required',
              'description' => 'required',
        ]);
        $data = $request->all();
        #make default password
        $data['password'] = GlobalParam::where('code', 'DEFAULT_PASS')->first()->value;
        $data['user_detail_id'] = auth()->user()->user_detail_id;
        try {
            //code...
            $response = $this->transactionService->checkout($data);
        } catch (\Throwable $th) {
            Alert::error('error', $th->getMessage());
        }
        #receipt waiting payment
          dd($response);
        return view('receipt', [
            'status' => $response['status'],
            'data' => $response['transaction'],
            ]);
    }

    public function uploadFileCheckout(Request $request)
    {
          if (!$request->hasFile('file')) {
                return response()->json([
                      'status' => false,
                      'message' => 'File not found'
                ]);
          }
          try {
                $response = $this->methodService->saveFile($request);
          } catch (\Throwable $th) {
                return response()->json([
                      'status' => false,
                      'message' => $th->getMessage(),
                ]);
          }
          return response()->json([
                'status' => true,
                'file_paths' => $response['file_paths'],
                'message' => 'File uploaded successfully',
          ]);
    }

}
