<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\BalanceEntryRepository;
use App\Repositories\Interfaces\BalanceEntryRepositoryInterface;
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
        $this->app->bind(
            UserRepositoryInterface::class, 
            UserRepository::class
        );

        $this->app->bind(
            BalanceEntryRepositoryInterface::class, 
            BalanceEntryRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
