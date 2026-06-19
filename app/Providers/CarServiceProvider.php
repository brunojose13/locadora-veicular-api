<?php

namespace App\Providers;

use App\Domain\Ports\In\ICarRepository;
use App\Domain\Ports\In\ICarService;
use App\Domain\Services\CarService;
use App\Infrastructure\Repositories\CarRepository;
use Illuminate\Support\ServiceProvider;

class CarServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ICarRepository::class, CarRepository::class);
        $this->app->singleton(ICarService::class, CarService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
