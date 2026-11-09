<?php

namespace Modules\Payout\Providers;

use Illuminate\Support\ServiceProvider;

class PayoutServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'module_payout');

        $this->app->register(RouteServiceProvider::class);
    }
}
