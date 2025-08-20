<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use Illuminate\Support\Facades\Log;
use App\Models\TransactionsModel;
use App\Models\User;
use App\Services\MethodServiceUtil;
use App\Services\TransactionsInterface;
use ErrorException;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

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
        try {
            // Remove any spaces from card number
            if ($request->has('card_number')) {
                $request->merge([
                    'card_number' => preg_replace('/\s+/', '', $request->card_number),
                ]);
            }

            // Validate the request
            $rules = [
                'full_name' => 'required|string|max:255',
                'email' => 'required|email',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'card_number' => 'required|string',
                'product_code' => 'required|string',
                'due_date' => 'required|date_format:Y-m-d H:i',
                'uploaded_files' => 'sometimes|array',
                'uploaded_files.*' => 'sometimes|string',
              'product_group_name' => 'required|string',
              'price' => 'required|numeric',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                Log::error('Validation failed:', $validator->errors()->toArray());
                Alert::warning('Warning', Constant::MESSAGE_WARNING);
                return redirect()->back();
            }

            // Get the validated data
            $data = $validator->validated();

            // Handle due_date
            if (isset($data['due_date'])) {
                try {
                    $data['due_date'] = \Carbon\Carbon::parse($data['due_date'])->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    throw new \Exception('Invalid date format. Please use YYYY-MM-DD HH:MM');
                }
            }

            // Handle uploaded files if they exist
            if ($request->has('uploaded_files') && is_array($request->uploaded_files)) {
                $data['uploaded_files'] = $request->uploaded_files;
            } else {
                $data['uploaded_files'] = [];
            }

            Log::info('Processed data:', $data);

            // Process the checkout using the service
            try {
                $transaction = $this->transactionService->checkout($data);
                if (!$transaction['status']) {
                      Log::error($transaction['message']);
                      Alert::warning('Warning', Constant::MESSAGE_WARNING);
                      return redirect()->route('landing')->withInput();
                }
                return redirect()->route('receipt', ['id' => $transaction['transaction_id']]);
            } catch (\Exception $e) {
                Log::error('Transaction Checkout error: ', [
                      'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                Alert::error('Error', Constant::MESSAGE_ERROR);
                return redirect()->route('landing')->withInput();
            }

        } catch (\Exception $e) {
            Log::error('Transaction checkout process error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['card_number', '_token'])
            ]);
            Alert::error('Failed', Constant::MESSAGE_ERROR);
            return redirect()->route('landing')->withInput();
        }
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


      /*
       * show receipt
       * @param string $id
       */
      public function receipt(string $id)
      {
            try{
                  $transaction = TransactionsModel::findOrFail($id);
                  $user = User::where('user_detail_id', $transaction->user_id)->first();
                  return view('transaction.receipt', compact('transaction', 'user'));
            }catch (ErrorException $e){
                  \Log::error($e->getMessage());
                  return view('errors.500');
            }
      }

}
