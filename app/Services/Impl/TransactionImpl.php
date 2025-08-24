<?php

namespace App\Services\Impl;

use App\Models\Users\User;
use Illuminate\Support\Facades\Log;
use App\Helpers\Constant;
use App\Helpers\GenerateId;
use App\Mail\Receipt;
use App\Models\Tasks\DetailTaskModel;
use App\Models\GlobalParam;
use App\Models\Tasks\TaskFilesModel;
use App\Models\Tasks\TaskModel;
use App\Models\TransactionsModel;
use App\Models\Users\UserDetailModel;
use App\Services\AuthInterface;
use App\Services\TransactionsInterface;
use Exception;
use Illuminate\Support\Facades\Mail;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class TransactionImpl implements TransactionsInterface
{
    protected AuthInterface $authService;
      public function __construct(AuthInterface $authService)
      {
            $this->authService = $authService;
      }

      /**
       * @throws InternalErrorException
       * @throws Exception
       */
      public function checkoutByMidtrans($data): array
    {
        $data['user_id'] = $this->id_user;
        try {
              UserDetailModel::where('id', $this->user_detail_id)->lockForUpdate()->first();
            DB::transaction(function () use ($data) {
                TransactionsModel::create($data);
            }, Constant::DB_ATTEMPT);
        } catch (Throwable $th) {
            throw new InternalErrorException($th->getMessage());
        }

        #token
        $params = [
            'transaction_details' => [
                'order_id' => GenerateId::generateId(Constant::TRANS_ID, false),
                'gross_amount' => $data['amount'],
            ],
            'customer_details' => [
                'first_name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'phone' => $data['customer_phone']
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        return [
            'transaction' => $data, // Return the transaction data instead of the service
            'snap_token' => $snapToken
        ];
    }

      /**
       * @throws Throwable
       */
      public function checkout($data): array
    {
//        dd($data);
          Log::info('Begin TransactionImpl.checkout');
          #prepare data for check register user
            $data['role'] = 'client';
            $data['password'] = GlobalParam::where("code", "=", Constant::DEFAULT_PASS)->value("value");
            $data['skills'] = '';
            $data['tag_line'] = '';
            $data['username'] = $data['email'];
            try {
                  $user_detail_id = '';
                  $userRegisterResponse = $this->authService->register($data, true);
                  #get response for email user has been registered
                if (!$userRegisterResponse['status']) {
                      $user = User::where('email', $data['email'])->first();
                      $user_detail_id = $user->user_detail_id;
                } else {
                      $user_detail_id = $userRegisterResponse['user']->user_detail_id;
                }
                DB::beginTransaction();
                        $detailTask = DetailTaskModel::create([
                              'id' => GenerateId::generateId('DTK', false),
                              'title' => $data['title'],
                              'description' => $data['description'],
                              'task_type' => Constant::TASK_TYPE_CATALOG_PRODUCT,
                              'price' => $data['price'],
                              'task_contract' => Constant::TASK_INQUIRY,
                              'required_skills' => $data['skills']
                        ]);
                      $task = TaskModel::create([
                            'id' => GenerateId::generateId('TSK', false),
                            'kanban_id' => GenerateId::generateId('KBN', false),
                            'client_id' => $user_detail_id,
                            'detail_task_id' => $detailTask->id,
                            'deadline' => $data['due_date']
                      ]);

                      $transaction = TransactionsModel::create([
                            'id' => GenerateId::generateId(Constant::TRANS_ID, false),
                            'task_id' => $task->id,
                            'user_id' => $user_detail_id,
                            'product_id' => $data['product_code'],
                            'product_type' => $data['product_group_name'],
                            'payment_method' => Constant::PAYMENT_BANK,
                            'total_price' => $data['price'],
                            'status' => false,
                      ]);

                      $isFilesInserted = true;
                      if (!empty($data['uploaded_files'])) {
                            foreach ($data['uploaded_files'] as $file_path) {
                                  $absolute_path = public_path($file_path);
                                  $created = TaskFilesModel::create([
                                        'task_id' => $task->id,
                                        'file_path' => $file_path,
                                        'file_name' => basename($absolute_path) ?: 'application/octet-stream',
                                        'file_type' => Constant::FILE_TYPE_CHECKOUT,
                                        'mime_type' => mime_content_type($absolute_path) ?: 'application/octet-stream',
                                        'file_size' => filesize($absolute_path) ?: 'application/octet-stream',
                                  ]);
                                  if (!$created) {
                                        $isFilesInserted = false;
                                        break;
                                  }
                            }
                      }
                      $status = $task && $detailTask && $isFilesInserted;
          }catch (Throwable $th) {
                  Log::error('TransactionImpl.checkout', [$th->getMessage()]);
                  DB::rollBack();
                DB::rollBack();
                #delete related user
                  $this->authService->deleteRelatedUser($user_detail_id);
                throw new InternalErrorException($th->getMessage());
          }
          if (!$status) {
                DB::rollBack();
                $this->authService->deleteRelatedUser($user_detail_id);
                return [
                      'status' => false,
                      'message' => 'Transaction Checkout failed status false'
                ];
          }
          DB::commit();
        return [
            'status' => true,
              'message' => 'Transaction checkout success',
              'transaction_id' => $transaction->id
        ];
    }

      /**
       * @throws InternalErrorException
       */
      public function withdrawCoins($data): array
    {
        try {
            DB::transaction(function () use ($data) {
                $user_detail = UserDetailModel::where('id', $this->user_detail_id)->lockForUpdate()->first();
                #validation amount of coins will be handle in controller or view
                $user_detail->update(['balance' => $user_detail->balance_coins - $data['amount']]);
                $this->transactionService = TransactionsModel::create($data);
            }, Constant::DB_ATTEMPT);
        } catch (Throwable $th) {
            throw new InternalErrorException($th->getMessage());
        }



        return [
            'transaction' => $this->transactionService
        ];
    }

    public function approvedWithdrawCoins($id): bool
    {
        $transaction = TransactionsModel::find($id);
        $transaction->status = true;
        $transaction->save();
        return true;
    }

      /**
       * @throws Throwable
       */
      public function approvedPayment($id): array
    {
          $transaction = TransactionsModel::find($id)->lockForUpdate()->first();
        DB::transaction(function () use ($transaction) {
            $transaction->status = true;
            $transaction->save();
            return $transaction;
        }, Constant::DB_ATTEMPT);
        $this->sendAccountAndReceiptByMail($transaction->toArray());
        #those email will include link email account verification to active

        broadcast(new NotificationSent('Your transaction has been approved.', $transaction->user_id));
        return [
            'transaction' => $transaction
        ];
    }

    public function sendAccountAndReceiptByMail($data): void
    {
        Mail::to($data['customer_email'])->send(new Receipt($data));
    }

    public function getAllTransactionByTask($status = 'done'): Collection
    {
        if ($status != 'done') {
            # code...
              return  TransactionsModel::with(['user', 'task'])->get();
        }
        return TransactionsModel::with(['user', 'task'])->where('status', $status)->get();
    }

}
