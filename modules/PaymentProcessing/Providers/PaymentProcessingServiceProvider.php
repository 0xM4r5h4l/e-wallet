<?php

namespace Modules\PaymentProcessing\Providers;

use Illuminate\Support\ServiceProvider;

class PaymentProcessingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'module_payment_processing');

        $this->app->register(RouteServiceProvider::class);
    }
}
