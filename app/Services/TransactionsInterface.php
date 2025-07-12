<?php

namespace App\Repositories;

interface TransactionsInterface
{
    public function checkout($data): array;
    public function withdrawCoins($data): array;
    #approved withdraw coins handle by Admin Role
    public function approvedWithdrawCoins($id);
}
