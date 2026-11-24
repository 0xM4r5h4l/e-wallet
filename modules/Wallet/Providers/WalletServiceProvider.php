<?php

namespace Modules\Wallet\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Modules\Auth\Events\UserRegistered;
use Modules\Wallet\Listeners\CreateDefaultWallet;
use Modules\Wallet\Models\Wallet;
use Modules\Wallet\Policies\WalletPolicy;

class WalletServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'module_wallet');

        Gate::policy(Wallet::class, WalletPolicy::class);
        $this->app->register(RouteServiceProvider::class);

        Event::listen(
            UserRegistered::class,
            CreateDefaultWallet::class
        );
    }
}
