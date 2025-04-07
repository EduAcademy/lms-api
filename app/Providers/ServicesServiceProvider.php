<?php

namespace App\Providers;

use App\Interfaces\Services\AbsenceServiceInterface;
use App\Services\RoleService;
use App\Services\UserService;
use App\Services\GroupService;
use App\Services\LevelService;
use App\Services\CourseService;
use App\Services\StudentService;
use App\Services\SubGroupService;
use App\Services\StudyPlanService;
use App\Services\AssignmentService;
use App\Services\DepartmentService;
use App\Services\InstructorService;
use App\Services\NotificationService;
use App\Services\CourseMaterialService;
use Illuminate\Support\ServiceProvider;
use App\Services\StudyPlanCourseService;
use App\Interfaces\Services\RoleServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Interfaces\Services\GroupServiceInterface;
use App\Interfaces\Services\LevelServiceInterface;
use App\Services\StudyPlanCourseInstructorService;
use App\Interfaces\Services\CourseServiceInterface;
use App\Interfaces\Services\StudentServiceInterface;
use App\Interfaces\Services\SubGroupServiceInterface;
use App\Interfaces\Services\StudyPlanServiceInterface;
use App\Interfaces\Services\AssignmentServiceInterface;
use App\Interfaces\Services\DepartmentServiceInterface;
use App\Interfaces\Services\InstructorServiceInterface;
use App\Interfaces\Services\NotificationServiceInterface;
use App\Services\StudyPlanCourseInstructorSubGroupService;
use App\Interfaces\Services\CourseMaterialServiceInterface;
use App\Interfaces\Services\StudyPlanCourseServiceInterface;
use App\Interfaces\Services\StudyPlanCourseInstructorServiceInterface;
use App\Interfaces\Services\StudyPlanCourseInstructorSubGroupServiceInterface;
use App\Interfaces\Services\GroupServiceInterface as ServicesGroupServiceInterface;
use App\Services\AbsenceService;

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
        $this->app->bind(GroupServiceInterface::class, GroupService::class);
        $this->app->bind(CourseMaterialServiceInterface::class, CourseMaterialService::class);
        $this->app->bind(InstructorServiceInterface::class, InstructorService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(StudyPlanCourseServiceInterface::class, StudyPlanCourseService::class);
        $this->app->bind(StudyPlanCourseInstructorServiceInterface::class, StudyPlanCourseInstructorService::class);
        $this->app->bind(StudyPlanCourseInstructorSubGroupServiceInterface::class, StudyPlanCourseInstructorSubGroupService::class);
        $this->app->bind(SubGroupServiceInterface::class, SubGroupservice::class);
        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);
        $this->app->bind(LevelServiceInterface::class, LevelService::class);
        $this->app->bind(AssignmentServiceInterface::class, AssignmentService::class);
        $this->app->bind(AbsenceServiceInterface::class, AbsenceService::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
