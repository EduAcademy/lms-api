<?php

namespace App\Providers;

use App\Contracts\CourseMaterialRepositoryInterface;
use App\Contracts\CourseRepositoryInterface;
use App\Contracts\GenericRepositoryInterface;
use App\Repositories\DepartmentRepository;
use App\Contracts\DepartmentRepositoryInterface;
use App\Contracts\InstructorRepositoryInterface;
use App\Contracts\LabGroupRepositoryInterface;
use App\Contracts\StuCouInstrGroupRepositoryInterface;
use App\Contracts\StudentRepositoryInterface;
use App\Contracts\StudyPlanRepositoryInterface;
use App\Contracts\TheoreticalGroupRepositoryInterface;
use App\Repositories\InstructorRepository;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\CourseMaterialRepository;
use App\Repositories\CourseRepository;
use App\Repositories\GenericRepository;
use App\Repositories\LabGroupRepository;
use App\Repositories\StuCouInstrGroupRepository;
use App\Repositories\StudentRepository;
use App\Repositories\StudyPlanRepository;
use App\Repositories\TheoreticalGroupRepository;
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
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(StudyPlanRepositoryInterface::class, StudyPlanRepository::class);
        $this->app->bind(LabGroupRepositoryInterface::class, LabGroupRepository::class);
        $this->app->bind(TheoreticalGroupRepositoryInterface::class, TheoreticalGroupRepository::class);
        $this->app->bind(CourseMaterialRepositoryInterface::class, CourseMaterialRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
