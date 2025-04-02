<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\CourseMaterialController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Instructor\InstructorController;
use App\Http\Controllers\SubGroupController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudyPlanController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudyPlanCourseController;
use App\Http\Controllers\StudyPlanCourseInstructorController;
use App\Http\Controllers\StudyPlanCourseInstructorSubGroupController;
use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware('customThrottle:3,1');
    Route::post('/validate-token', [AuthController::class, 'validateToken']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('v1')->group(function () {
        // User profile and authentication
        Route::prefix('auth')->group(function () {
            Route::get('/profile', [AuthController::class, 'profile']);
            Route::post('/update-profile', [AuthController::class, 'updateProfile']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
            Route::post('/reset-password', [AuthController::class, 'resetPassword']);
            Route::patch('/activate/{id}', [AuthController::class, 'activateUser']);
            Route::patch('/deactivate/{id}', [AuthController::class, 'deactivateUser']);
        });

        // User management

        Route::prefix('users')->group(function () {
            Route::get('/', [AuthController::class, 'index']);
            Route::get('/{id}', [AuthController::class, 'show']);
            Route::patch('/{id}', [AuthController::class, 'patch']);
            Route::delete('/{id}', [AuthController::class, 'delete']);
        });

        Route::prefix('roles')->group(function () {
            Route::get('/', [RoleController::class, 'index']);
        });

        Route::post('/upload-students', [StudentController::class, 'uploadStudent']);
        Route::post('/upload-depts', [DepartmentController::class, 'createDepartment']);

        // Department routes
        Route::prefix('departments')->group(function () {
            Route::get('/', [DepartmentController::class, 'index']);
            Route::get('/{id}', [DepartmentController::class, 'show']);
            Route::post('/', [DepartmentController::class, 'store']);
            Route::put('/{id}', [DepartmentController::class, 'update']);
            Route::delete('/{id}', [DepartmentController::class, 'delete']);
        });

        // Instructor routes
        Route::prefix('instructors')->group(function () {
            Route::get('/', [InstructorController::class, 'index']);
            Route::get('/{id}', [InstructorController::class, 'show']);
            Route::post('/', [InstructorController::class, 'store']);
            Route::put('/{id}', [InstructorController::class, 'update']);
            Route::delete('/{id}', [InstructorController::class, 'destroy']);
        });

        // Student routes
        Route::prefix('students')->group(function () {
            Route::get('/', [StudentController::class, 'index']);
            Route::get('/{id}', [StudentController::class, 'show']);
            Route::post('/', [StudentController::class, 'store']);
            Route::put('/{id}', [StudentController::class, 'update']);
            Route::delete('/{id}', [StudentController::class, 'destroy']);
        });

        // Course routes
        Route::prefix('courses')->group(function () {
            Route::get('/', [CourseController::class, 'index']);
            Route::get('/{id}', [CourseController::class, 'show']);
            Route::get('/department/{departmentId}', [CourseController::class, 'showbyDepartment']);
            Route::post('/', [CourseController::class, 'store']);
            Route::put('/{id}', [CourseController::class, 'update']);
            Route::delete('/{id}', [CourseController::class, 'delete']);
        });

        // Study Plan routes
        Route::prefix('study_plans')->group(function () {
            Route::get('/', [StudyPlanController::class, 'index']);
            Route::get('/{id}', [StudyPlanController::class, 'show']);
            Route::get('/department/{departmentId}', [StudyPlanController::class, 'showbyDepartment']);
            Route::get('/course/{courseId}', [StudyPlanController::class, 'showbyCourse']);
            Route::post('/', [StudyPlanController::class, 'store']);
            Route::put('/{id}', [StudyPlanController::class, 'update']);
            Route::delete('/{id}', [StudyPlanController::class, 'delete']);
        });

        // Theoretical Group routes
        Route::prefix('groups')->group(function () {
            Route::get('/', [GroupController::class, 'index']);
            Route::get('/{id}', [GroupController::class, 'show']);
            Route::get('/group/{name}', [GroupController::class, 'showByName']);
            Route::post('/', [GroupController::class, 'store']);
            Route::put('/{id}', [GroupController::class, 'update']);
            Route::patch('/{id}', [GroupController::class, 'update']);
            Route::delete('/{id}', [GroupController::class, 'delete']);
        });

        Route::prefix('levels')->group(function () {
            Route::get('/', [LevelController::class, 'index']);
            Route::post('/', [LevelController::class, 'store']);
        });

        // Lab Group routes
        Route::prefix('sub_groups')->group(function () {
            Route::get('/', [SubGroupController::class, 'index']);
            Route::get('/{id}', [SubGroupController::class, 'show']);
            Route::get('/sub_group/{name}', [SubGroupController::class, 'showByName']);
            Route::post('/', [SubGroupController::class, 'store']);
            Route::put('/{id}', [SubGroupController::class, 'update']);
            Route::delete('/{id}', [SubGroupController::class, 'delete']);
            Route::get('/group/{id}', [SubGroupController::class, 'showByGroupId']);
        });

        // Course Materials routes
        Route::prefix('course_materials')->group(function () {
            Route::get('/', [CourseMaterialController::class, 'index']);
            Route::get('/{id}', [CourseMaterialController::class, 'show']);
            Route::post('/', [CourseMaterialController::class, 'store']);
            Route::put('/{id}', [CourseMaterialController::class, 'update']);
            Route::delete('/{id}', [CourseMaterialController::class, 'delete']);
        });

        Route::prefix('study_plan_courses')->group(function () {
            Route::get('/', [StudyPlanCourseController::class, 'index']);
            Route::get('/{id}', [StudyPlanCourseController::class, 'show']);
            Route::post('/', [StudyPlanCourseController::class, 'store']);
            Route::put('/{id}', [StudyPlanCourseController::class, 'update']);
            Route::delete('/{id}', [StudyPlanCourseController::class, 'delete']);
        });

        Route::prefix('study_plan_course_instructors')->group(function () {
            Route::get('/', [StudyPlanCourseInstructorController::class, 'index']);
            Route::get('/{id}', [StudyPlanCourseInstructorController::class, 'show']);
            Route::post('/', [StudyPlanCourseInstructorController::class, 'store']);
            Route::put('/{id}', [StudyPlanCourseInstructorController::class, 'update']);
            Route::delete('/{id}', [StudyPlanCourseInstructorController::class, 'delete']);
        });

        Route::prefix('study_plan_course_instructor_sub_groups')->group(function () {
            Route::get('/', [StudyPlanCourseInstructorSubGroupController::class, 'index']);
            Route::get('/{id}', [StudyPlanCourseInstructorSubGroupController::class, 'show']);
            Route::post('/', [StudyPlanCourseInstructorSubGroupController::class, 'store']);
            Route::put('/{id}', [StudyPlanCourseInstructorSubGroupController::class, 'update']);
            Route::delete('/{id}', [StudyPlanCourseInstructorSubGroupController::class, 'delete']);
        });

        Route::prefix('notifications')->group(function () {
            Route::post('/all', [NotificationController::class, 'notifyAllStudents']);
            Route::post('/department', [NotificationController::class, 'notifyDepartment']);
            Route::post('/group', [NotificationController::class, 'notifyGroup']);
            Route::post('/student', [NotificationController::class, 'notifyStudent']);
        });

        // Stats routes
        Route::prefix('stats')->group(function () {
            Route::get('/', StatsController::class);
        });
    });
});
