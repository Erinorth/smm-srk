<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Force root URL สำหรับ subfolder
        \URL::forceRootUrl(config('app.url'));
        
        // ถ้าใช้ HTTPS
        /* if (env('APP_ENV') === 'production') {
            \URL::forceScheme('https');
        } */
    }
}
