<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Auth\Interfaces\AuthServiceInterface;
use App\Services\Auth\AuthService;
use App\Services\Kost\Interfaces\KostServiceInterface;
use App\Services\Kost\KostService;

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
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(KostServiceInterface::class, KostService::class);
    }
}
