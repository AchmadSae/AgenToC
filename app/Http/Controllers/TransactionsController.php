<?php

namespace App\Http\Controllers;

use App\Helpers\Constant;
use App\Models\ProductsModel;
use App\Models\OrdersModel;
use App\Models\Tasks\DetailTaskModel;
use App\Models\Tasks\TaskModel;
use App\Models\Users\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
                return redirect()->route('receipt', ['id' => $transaction['order_id']]);
            } catch (\Exception $e) {
                Log::error('Transaction Checkout error: ', [
                      'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                Alert::error('Error', Constant::MESSAGE_ERROR);
                return redirect()->back();
            }

        } catch (\Exception $e) {
            Log::error('Transaction checkout process error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['card_number', '_token'])
            ]);
            Alert::error('Failed', Constant::MESSAGE_ERROR);
            return redirect()->back();
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
                  $order = OrdersModel::where('order_id', $id)->first();
                  $task = TaskModel::select('task_type','task_contract', 'deadline')
                        ->join('task_detail', 'tasks.task_detail_id', '=','task_detail.id')
                        ->where('tasks.task_id', $order->task_id)
                        ->first();
                  $product = ProductsModel::select('products.*','product_groups.*')
                        ->join('product_groups', 'products.product_group_code', '=', 'product_groups.code')
                        ->where('product_code', $order->product_code)
                        ->first();
                  $user = User::select('users.*', 'user_detail.*')
                        ->join('user_detail', 'users.user_detail_id', '=', 'user_detail.user_detail_id')
                        ->where('user_detail.user_detail_id', $order->user_detail_id)
                        ->first();
                  $status = $task && $product && $user;
                  if (!$status) {
                        return view('errors.404');
                  }
//                  dd($task);
                  return view('transaction.receipt', compact('order','product', 'user', 'task'));
            }catch (ErrorException $e){
                  \Log::error($e->getMessage());
                  return view('errors.500');
            }
      }

}
