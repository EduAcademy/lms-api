<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use App\Repositories\GroupRepository;
use App\Repositories\LevelRepository;
use App\Repositories\CourseRepository;
use App\Repositories\GenericRepository;
use App\Repositories\StudentRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\SubGroupRepository;
use App\Repositories\StudyPlanRepository;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\AssignmentRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\InstructorRepository;
use App\Contracts\GroupRepositoryInterface;
use App\Contracts\LevelRepositoryInterface;
use App\Contracts\CourseRepositoryInterface;
use App\Repositories\NotificationRepository;
use App\Contracts\GenericRepositoryInterface;
use App\Contracts\StudentRepositoryInterface;
use App\Contracts\SubGroupRepositoryInterface;
use App\Repositories\CourseMaterialRepository;
use App\Contracts\StudyPlanRepositoryInterface;
use App\Repositories\StudyPlanCourseRepository;
use App\Contracts\AssignmentRepositoryInterface;
use App\Contracts\DepartmentRepositoryInterface;
use App\Contracts\InstructorRepositoryInterface;
use App\Contracts\NotificationRepositoryInterface;
use App\Contracts\CourseMaterialRepositoryInterface;
use App\Contracts\StudyPlanCourseRepositoryInterface;
use App\Repositories\StudyPlanCourseInstructorRepository;
use App\Contracts\StudyPlanCourseInstructorRepositoryInterface;
use App\Repositories\StudyPlanCourseInstructorSubGroupRepository;
use App\Contracts\StudyPlanCourseInstructorSubGroupRepositoryInterface;

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
        $this->app->bind(SubGroupRepositoryInterface::class, SubGroupRepository::class);
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
        $this->app->bind(CourseMaterialRepositoryInterface::class, CourseMaterialRepository::class);
        $this->app->bind(StudyPlanCourseRepositoryInterface::class, StudyPlanCourseRepository::class);
        $this->app->bind(StudyPlanCourseInstructorRepositoryInterface::class, StudyPlanCourseInstructorRepository::class);
        $this->app->bind(StudyPlanCourseInstructorSubGroupRepositoryInterface::class, StudyPlanCourseInstructorSubGroupRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(LevelRepositoryInterface::class, LevelRepository::class);
        $this->app->bind(AssignmentRepositoryInterface::class, AssignmentRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
