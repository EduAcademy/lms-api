<?php

namespace App\Providers;

use App\Interfaces\Services\DepartmentService;
use App\Interfaces\Services\DepartmentServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(DepartmentServiceInterface::class, DepartmentService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
