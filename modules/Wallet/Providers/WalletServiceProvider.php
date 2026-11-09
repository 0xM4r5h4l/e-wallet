<?php

namespace Modules\Wallet\Providers;

use Illuminate\Support\ServiceProvider;

class WalletServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'module_wallet');

        $this->app->register(RouteServiceProvider::class);
    }
}
