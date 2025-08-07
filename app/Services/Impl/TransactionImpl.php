<?php

namespace App\Services\Impl;

use App\Events\NotificationSent;
use App\Helpers\Constant;
use App\Helpers\GenerateId;
use App\Mail\Receipt;
use App\Helpers\Log;
use App\Models\TransactionsModel;
use App\Models\User;
use App\Models\UserDetailModel;
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
        $response = DB::transaction(function () use ($data) {
            User::where('email', $data['email'])->lockForUpdate()->first();
            return TransactionsModel::create([
                'user_id' => $data['email'],
                'product_id' => $data['product_id'],
                'product_type' => $data['product_type'],
                'payment_method' => Constant::PAYMENT_BANK,
                'status' => false,
            ]);
        }, Constant::DB_ATTEMPT);
        #debug
        Log::browser($data, 'Checkout User');
        #check user isRegistered
        $flag = $this->authService->hasVerifiedEmail($data['email']);
        if (!$flag) {
            #register user
            $this->authService->register($data, true);
        }
        return [
            'transaction' => $response
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
