<?php

declare(strict_types=1);

namespace Modules\Wallet\Policies;

use Modules\Auth\Models\User;
use Modules\Wallet\Models\Wallet;

class WalletPolicy
{
    public function view(User $user, Wallet $wallet): bool
    {
        return $user->id === $wallet->user_id;
    }
}
