<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Services\StatsServiceInterface;
use App\Services\StatsService;
use App\Repositories\StudentRepositoryInterface;
use App\Repositories\StudentRepository;
use App\Interfaces\Repositories\InstructorRepositoryInterface;
use App\Repositories\InstructorRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(StatsServiceInterface::class, StatsService::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(InstructorRepositoryInterface::class, InstructorRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
