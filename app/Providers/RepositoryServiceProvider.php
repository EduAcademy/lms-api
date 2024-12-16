<?php

namespace App\Providers;

use App\Contracts\CourseRepositoryInterface;
use App\Contracts\GenericRepositoryInterface;
use App\Repositories\DepartmentRepository;
use App\Contracts\DepartmentRepositoryInterface;
use App\Contracts\InstructorRepositoryInterface;
use App\Repositories\InstructorRepository;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\CourseRepository;
use App\Repositories\GenericRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(InstructorRepositoryInterface::class, InstructorRepository::class);
        $this->app->bind(GenericRepositoryInterface::class, GenericRepository::class);
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
