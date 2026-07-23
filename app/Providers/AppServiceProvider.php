<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Kalau request datang lewat proxy HTTPS (misal Cloudflare Tunnel),
        // paksa Laravel generate semua link (asset, form action, redirect)
        // pakai skema https:// juga. Tanpa ini, Laravel nggak tau kalau
        // dia diakses lewat HTTPS karena php artisan serve lokal jalannya
        // plain HTTP di baliknya.
        if (request()->header('X-Forwarded-Proto') === 'https' || request()->secure()) {
            URL::forceScheme('https');
        }
    }
}