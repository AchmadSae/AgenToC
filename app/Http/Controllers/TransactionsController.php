<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Helpers\Log;
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

    public function __construct(TransactionsInterface $transactionService, MethodServiceUtil $methodService)
    {
        $this->transactionService = $transactionService;
        $this->methodService = $methodService;
    }

    public function checkout(Request $request)
    {
        $response = [];
        $request->merge([
              'card_number' => preg_replace('/\s+/', '', $request->card_number),
        ]);
        #validation
        $request->validate([
              'email' => 'required|email',
              'name' => 'required',
              'product_code' => 'required',
              'title' => 'required|max:100',
              'card_number' => 'required|numeric',
              'description' => 'required',
              'uploaded_files' => 'nullable',
        ]);
        Log::browser('past validation', $request);
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
        return view('transaction.receipt', [
            'status' => $response['status'],
            'data' => $response['transaction'],
            ]);
    }

    public function uploadFileCheckout(Request $request)
    {
          if (!$request->hasFile('files')) {
                return response()->json([
                      'status' => false,
                      'message' => 'File(s) not found'
                ]);
          }
          $allPaths = [];
          try {
                foreach ((array) $request->file('files') as $file) {
                      if ($file) {
                            $response = $this->methodService->saveFile($file);
                            // saveFile may return ['file_paths' => [...]] or single path; normalize
                            if (isset($response['file_paths']) && is_array($response['file_paths'])) {
                                  $allPaths = array_merge($allPaths, $response['file_paths']);
                            } elseif (isset($response['path'])) {
                                  $allPaths[] = $response['path'];
                            }
                      }
                }
          } catch (\Throwable $th) {
                return response()->json([
                      'status' => false,
                      'message' => $th->getMessage(),
                ]);
          }
          return response()->json([
                'status' => true,
                'file_paths' => array_values(array_unique($allPaths)),
                'message' => 'File uploaded successfully',
          ]);
    }

}
