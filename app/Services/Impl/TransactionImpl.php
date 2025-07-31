<?php

namespace App\Services\Impl;

use App\Helpers\Constant;
use App\Mail\Receipt;
use App\Helpers\Log;
use App\Models\GlobalParam;
use App\Models\TransactionsModel;
use App\Models\User;
use App\Models\UserDetailModel;
use App\Services\AuthInterface;
use App\Services\TransactionsInterface;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;
use App\Events\NotificationTrigger;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Illuminate\Database\Eloquent\Collection;

class TransactionImpl implements TransactionsInterface
{
    protected $authService;
    protected $transaction;
    protected $id_user;
    protected $user_detail_id;
    protected $globalDBattempts;
    public function __construct(AuthInterface $authInterface)
    {
        $this->globalDBattempts = GlobalParam::get('DB_ATTEMPTS')->value;
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = true;
        $this->id_user = auth()->user()->email;
        $this->authService = $authInterface;
    }


    public function checkoutByMidtrans($data): array
    {
        $data['user_id'] = $this->id_user;
        try {
            DB::transaction(function () use ($data) {
                UserDetailModel::where('id', $this->user_detail_id)->lockForUpdate()->first();
                $this->transaction = TransactionsModel::create($data);
            }, $this->globalDBattempts);
        } catch (\Throwable $th) {
            throw new InternalErrorException($th->getMessage());
        }

        #token
        $params = [
            'transaction_details' => [
                'order_id' => $this->transaction->id,
                'gross_amount' => $this->transaction->total_price
            ],
            'customer_details' => [
                'first_name' => $data['customer_name'],
                'email' => $data['customer_email'],
                'phone' => $data['customer_phone']
            ]
        ];

        $snapToken = Snap::getSnapToken($params);
        return [
            'transaction' => $this->transaction,
            'snap_token' => $snapToken
        ];
    }

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
        }, $this->globalDBattempts);
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

    public function withdrawCoins($data): array
    {
        try {
            DB::transaction(function () use ($data) {
                $user_detail = UserDetailModel::where('id', $this->user_detail_id)->lockForUpdate()->first();
                #validation amount of coins will be handle in controller or view
                $user_detail->update(['balance' => $user_detail->balance - $data['amount']]);
                $this->transaction = TransactionsModel::create($data);
            }, $this->globalDBattempts);
        } catch (\Throwable $th) {
            throw new InternalErrorException($th->getMessage());
        }



        return [
            'transaction' => $this->transaction
        ];
    }

    public function approvedWithdrawCoins($id): bool
    {
        $transaction = TransactionsModel::find($id);
        $transaction->status = true;
        $transaction->save();
        return true;
    }

    public function approvedPayment($id): array
    {
        $transaction = new TransactionsModel();
        DB::transaction(function () use ($id) {
            $this->user_detail_id = UserDetailModel::where('user_id', $this->id_user)->lockForUpdate()->first()->id;
            UserDetailModel::where('id', $this->user_detail_id)->lockForUpdate()->first();
            $transaction = TransactionsModel::find($id);
            $transaction->status = true;
            $transaction->save();
            return $transaction;
        }, $this->globalDBattempts);
        $this->sendAccountAndReceiptByMail($transaction->toArray());
        #those email will include link email account verification to active

        event(new NotificationTrigger($transaction->user_id, 'Checkout Approved', 'Your Transaction with id ' . $transaction->id . ' has been Checkout Approved'));
        return [
            'transaction' => $transaction
        ];
    }

    public function sendAccountAndReceiptByMail($data): void
    {
        $response = Mail::to($data['customer_email'])->send(new Receipt($data));
    }

    public function getAllTransactionByTask($status = 'done'): Collection
    {
        $data = [];
        if ($status != 'done') {
            # code...
            $data = TransactionsModel::with(['user', 'task'])->all();
        }

        $data = TransactionsModel::with(['user', 'task'])->where('status', $status)->get();

        return $data;
    }
}
