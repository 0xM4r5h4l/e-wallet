<?php

declare(strict_types=1);

namespace Modules\Wallet\Listeners;

use Modules\Auth\Events\UserRegistered;
use Modules\Wallet\Enums\Currency;
use Modules\Wallet\Services\WalletService;

class CreateDefaultWallet
{
    public function __construct(
        private WalletService $walletService
    ) {}

    public function handle(UserRegistered $event): void
    {
        $this->walletService->createWallet($event->userId, Currency::DEFAULT->value);
    }
}
