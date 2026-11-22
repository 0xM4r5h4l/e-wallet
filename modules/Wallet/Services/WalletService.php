<?php

declare(strict_types=1);

namespace Modules\Wallet\Services;

use Modules\Wallet\Models\Wallet;
use Illuminate\Support\Collection;

class WalletService
{
    public function createWallet(int $userId, string $currency): Wallet
    {
        return Wallet::create([
            'user_id' => $userId,
            'currency' => strtoupper($currency),
        ]);
    }

    public function getUserWallets(int $userId): Collection
    {
        return Wallet::where('user_id', $userId)->latest()->get();
    }

    public function getBalance(Wallet $wallet): int 
    {
        return $wallet->balance;
    }
}
