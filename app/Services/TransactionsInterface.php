<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

interface TransactionsInterface
{
    public function checkoutByMidtrans($data): array;
    public function checkout($data): array;
    public function withdrawCoins($data): array;
    #approved withdraw coins handle by Admin Role
    public function approvedWithdrawCoins($id);
    public function approvedPayment($id): array;
    #admin role
    public function sendAccountAndReceiptByMail($data): void;

    public function getAllTransactionByTask($status = 'done'): Collection;
}
