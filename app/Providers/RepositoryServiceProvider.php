<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Contracts\BookingRepository::class, \App\Repositories\BookingRepositoryEloquent::class);
        $this->app->bind(\App\Contracts\RoomRepository::class, \App\Repositories\RoomRepositoryEloquent::class);
        $this->app->bind(\App\Contracts\PaymentsRepository::class, \App\Repositories\PaymentsRepositoryEloquent::class);
        $this->app->bind(\App\Contracts\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        //:end-bindings:
    }
}
