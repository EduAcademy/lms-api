<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Services\StatsServiceInterface;
use App\Services\StatsService;
use App\Repositories\StudentRepositoryInterface;
use App\Repositories\StudentRepository;
use App\Interfaces\Repositories\InstructorRepositoryInterface;
use App\Repositories\InstructorRepository;
use App\Contracts\AssignmentStudentRepositoryInterface;
use App\Repositories\AssignmentStudentRepository;

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
        $this->app->bind(AssignmentStudentRepositoryInterface::class, AssignmentStudentRepository::class); // 👈 Added this line
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        //
    }
}
