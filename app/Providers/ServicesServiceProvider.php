<?php

namespace App\Providers;

use App\Interfaces\Services\CourseMaterialServiceInterface;
use App\Interfaces\Services\SubGroupserviceInterface;
use App\Interfaces\Services\StuCouInstrGroupServiceInterface;
use App\Interfaces\Services\GroupserviceInterface;
use App\Interfaces\Services\CourseServiceInterface;
use App\Services\DepartmentService;
use App\Interfaces\Services\DepartmentServiceInterface;
use App\Interfaces\Services\InstructorServiceInterface;
use App\Interfaces\Services\SubGroupserviceInterface as ServicesSubGroupserviceInterface;
use App\Interfaces\Services\StuCouInstrGroupServiceInterface as ServicesStuCouInstrGroupServiceInterface;
use App\Interfaces\Services\StudentServiceInterface;
use App\Interfaces\Services\StudyPlanServiceInterface;
use App\Interfaces\Services\GroupserviceInterface as ServicesGroupserviceInterface;
use App\Interfaces\Services\RoleServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Services\CourseMaterialService;
use App\Services\CourseService;
use App\Services\InstructorService;
use App\Services\SubGroupservice;
use App\Services\StuCouInstrGroupService;
use App\Services\StudentService;
use App\Services\StudyPlanService;
use App\Services\Groupservice;
use App\Services\RoleService;
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
        $this->app->bind(SubGroupserviceInterface::class, SubGroupservice::class);
        $this->app->bind(GroupserviceInterface::class, Groupservice::class);
        $this->app->bind(CourseMaterialServiceInterface::class, CourseMaterialService::class);
        $this->app->bind(InstructorServiceInterface::class, InstructorService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
