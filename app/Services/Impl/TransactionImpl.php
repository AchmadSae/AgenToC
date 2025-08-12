<?php

namespace App\Services\Impl;

use App\Events\NotificationSent;
use App\Helpers\Constant;
use App\Helpers\GenerateId;
use App\Mail\Receipt;
use App\Helpers\Log;
use App\Models\TaskFileModel;
use App\Models\TransactionsModel;
use App\Models\User;
use App\Models\UserDetailModel;
use App\Services\AuthInterface;
use App\Services\TransactionsInterface;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class TransactionImpl implements TransactionsInterface
{
    protected AuthInterface $authService;
    protected TransactionsInterface $transactionService;

      /**
       * @throws InternalErrorException
       * @throws Exception
       */
      public function checkoutByMidtrans($data): array
    {
        $data['user_id'] = $data->id_user;
        try {
              UserDetailModel::where('id', $data->user_detail_id)->lockForUpdate()->first();
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
          $savedFiles = [];
          $userDetailId = "";
        #check user isRegistered
          $authResponse = $this->authService->register($data, false);


        if (!$authResponse['success']) {
              #skip register and checkout
              $userDetailId = $authResponse['user_detail_id'];
        }else {
              $userDetailId = GenerateId::generateId('UD', true);
        }
          DB::beginTransaction();
                // Here you would also handle other form fields and potentially create a Task
                // For now, we only persist files and link to provided task_id if present
                TransactionsModel::create([
                      'user_id' => $userDetailId,
                      'product_id' => $data['product_id'],
                      'product_type' => $data['product_group_code'],
                      'payment_method' => $data['card_number'],
                      'status' => false,
                ]);
                if ($data->hasFile('files')) {
                      foreach ($data->file('files') as $file) {
                            $path = $file->store('file/task', 'public');

                            $record = TaskFileModel::create([
                                  'task_id' => $data->input('task_id', ''),
                                  'path' => $path,
                                  'file_map' => $data->input('file_map', ''),
                                  'original_name' => $file->getClientOriginalName(),
                                  'mime_type' => $file->getClientMimeType(),
                                  'size' => $file->getSize(),
                                  'disk' => 'public',
                            ]);

                            $savedFiles[] = [
                                  'id' => $record->id,
                                  'path' => $record->path,
                                  'file_map' => $record->file_map,
                                  'url' => Storage::disk('public')->url($record->path),
                                  'original_name' => $record->original_name,
                                  'mime_type' => $record->mime_type,
                                  'size' => $record->size,
                            ];
                      }
                }
                DB::commit();
        return [
            'success' => true,
              'message' => 'Checkout submitted and files saved.',
              'files' => $savedFiles,
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
