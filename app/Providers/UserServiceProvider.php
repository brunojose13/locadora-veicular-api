<?php

namespace App\Providers;

use App\Domain\Ports\In\IUserRepository;
use App\Domain\Ports\In\IUserService;
use App\Domain\Services\UserService;
use App\Infrastructure\Adapters\UserRepository;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(IUserRepository::class, UserRepository::class);
        $this->app->singleton(IUserService::class, UserService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
