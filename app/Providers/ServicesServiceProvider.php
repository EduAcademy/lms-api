<?php

namespace App\Providers;

use App\Interfaces\Services\CourseServiceInterface;
use App\Services\DepartmentService;
use App\Interfaces\Services\DepartmentServiceInterface;
use App\Interfaces\Services\StudentServiceInterface;
use App\Interfaces\Services\StudyPlanServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Services\CourseService;
use App\Services\StudentService;
use App\Services\StudyPlanService;
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
        $this->app->bind(CourseServiceInterface::class, CourseService::class);
        $this->app->bind(StudentServiceInterface::class, StudentService::class);
        $this->app->bind(StudyPlanServiceInterface::class, StudyPlanService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
