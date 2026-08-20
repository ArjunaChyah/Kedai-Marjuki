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
        View::share('creatorName', config('app.creator', 'ArjunaaChyh'));
        View::share('storePhone', config('app.phone', '0882005116301'));
        View::share('storeAddress', config('app.address', 'JL. Jomblang Perbalan No 800 Candi, Candisari, Semarang, Jawa Tengah'));
    }
}
