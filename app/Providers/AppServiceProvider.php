<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Force HTTPS scheme on tunnel / proxy to guarantee matching assets on mobile
        if (request()->server('HTTP_X_FORWARDED_PROTO') == 'https' || str_contains(request()->getHost(), 'trycloudflare.com') || str_contains(request()->getHost(), 'ngrok') || str_contains(request()->getHost(), 'lhr.life') || request()->isSecure()) {
            URL::forceScheme('https');
        }

        // Read directly from .env for 100% instant single-source configuration
        View::share('creatorName', env('APP_CREATOR', 'Arjuna Chyah'));
        View::share('storePhone', env('APP_PHONE', '0882005116301'));
        View::share('storeAddress', env('APP_ADDRESS', 'JL. Jomblang Perbalan No 800 Candi, Candisari, Semarang, Jawa Tengah'));
    }
}
