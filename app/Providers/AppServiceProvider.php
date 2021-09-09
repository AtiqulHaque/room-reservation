<?php

namespace App\Providers;

use App\Contracts\Service\BookingServiceContract;
use App\Contracts\Service\PaymentServiceContract;
use App\Contracts\Service\RoomServiceContarct;
use App\Contracts\Service\UserServiceContract;
use App\Services\BookingService;
use App\Services\PaymentService;
use App\Services\RoomService;
use App\Services\UserService;
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
        $this->app->bind(BookingServiceContract::class, BookingService::class);
        $this->app->bind(UserServiceContract::class, UserService::class);
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
