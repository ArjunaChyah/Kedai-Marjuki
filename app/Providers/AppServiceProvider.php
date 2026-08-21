<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        // Read directly from .env for 100% instant single-source configuration
        View::share('creatorName', env('APP_CREATOR', 'Arjuna Chyah'));
        View::share('storePhone', env('APP_PHONE', '0882005116301'));
        View::share('storeAddress', env('APP_ADDRESS', 'JL. Jomblang Perbalan No 800 Candi, Candisari, Semarang, Jawa Tengah'));
    }
}
