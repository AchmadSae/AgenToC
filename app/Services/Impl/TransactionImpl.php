<?php

namespace App\Services\Impl;

use App\Models\TransactionsModel;
use App\Models\UserDetailModel;
use App\Services\TransactionsInterface;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
class TransactionImpl implements TransactionsInterface
{

    protected $transaction;

    protected $id_user;
    protected $user_detail_id;
    public function __construct()
    {

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $this->id_user = auth()->user()->email;
    }


    public function checkout($data): array
    {
        $data['user_id'] = $this->id_user;
        try {
            DB::transaction(function () use ($data) {
                UserDetailModel::where('id', $this->user_detail_id)->lockForUpdate()->first();
                $this->transaction = TransactionsModel::create($data);
            }, 5);
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

    public function withdrawCoins($data): array
    {
        try {
            DB::transaction(function () use ($data) {
                $user_detail = UserDetailModel::where('id', $this->user_detail_id)->lockForUpdate()->first();
                #validation amount of coins will be handle in controller or view
                $user_detail->update(['balance' => $user_detail->balance - $data['amount']]);
                $this->transaction = TransactionsModel::create($data);
            }, 2);
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
}