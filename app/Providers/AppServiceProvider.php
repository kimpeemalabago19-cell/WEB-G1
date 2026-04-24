<?php

namespace App\Providers;

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
        if (request()->hasHeader('X-Forwarded-Proto')) {
            config(['app.url' => 'http://localhost/web-g2-laravel']);
        } else {
            config(['app.url' => request()->getSchemeAndHttpHost() . '/web-g2-laravel']);
        }
    }
}
