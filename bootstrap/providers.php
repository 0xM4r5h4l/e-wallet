<?php

return [
    App\Providers\AppServiceProvider::class,
    Modules\Wallet\Providers\WalletServiceProvider::class,
    Modules\PaymentProcessing\Providers\PaymentProcessingServiceProvider::class,
    Modules\Payout\Providers\PayoutServiceProvider::class,
    Modules\Auth\Providers\AuthServiceProvider::class,
    
];
