<?php

namespace App\Repositories;

interface TransactionsInterface
{
    public function topUpCoins($data): array;
    public function withdrawCoins($data): array;
}
