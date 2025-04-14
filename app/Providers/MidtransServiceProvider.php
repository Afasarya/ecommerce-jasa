<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Midtrans\Config;

class MidtransServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('midtrans', function ($app) {
            return new \App\Services\MidtransService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Set midtrans configurations
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.sanitize');
        Config::$is3ds = config('midtrans.3ds');
        
        // Force to env('MIDTRANS_SERVER_KEY') if empty and in debug
        if (empty(Config::$serverKey) && config('app.debug')) {
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        }
    }
}

