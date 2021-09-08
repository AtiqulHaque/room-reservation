<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Contracts\Service\RoomServiceContarct::class, \App\Services\RoomService::class);
        $this->app->bind(\App\Contracts\Service\PaymentServiceContract::class, \App\Services\PaymentService::class);
        $this->app->bind(\App\Contracts\Service\BookingServiceContract::class, \App\Services\BookingService::class);
        $this->app->bind(\App\Contracts\Service\UserServiceContract::class, \App\Services\UserService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
