<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        //
    }
}
