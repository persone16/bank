<?php

namespace App\Providers;

use App\Repositories\Interfaces\DatabaseRepositoryInterface;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Services\TransactionService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(TransactionService::class)
            ->needs(DatabaseRepositoryInterface::class)
            ->give(function () {
                return new TransactionRepository();
            });

        $this->app->when(UserService::class)
            ->needs(DatabaseRepositoryInterface::class)
            ->give(function () {
                return new UserRepository();
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
