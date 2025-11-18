<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    // unchanged... I simply imported my "Services" I am not sure
    // I did this correctly.
    // TODO: enquire about the proper way to use Services and ServiceProviders

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production', 'staging')) {
            // Force URL generation to use the HTTPS scheme
            URL::forceScheme('http');
        }
    }
}
