<?php

namespace App\Providers;

use App\Domain\Ports\In\IAuthService;
use App\Domain\Services\AuthService;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(IAuthService::class, AuthService::class);
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
