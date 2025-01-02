<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Course\CourseController;
use App\Http\Controllers\CourseMaterialController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Instructor\InstructorController;
use App\Http\Controllers\LabGroupController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentCourseInstructorGroupController;
use App\Http\Controllers\StudyPlanController;
use App\Http\Controllers\TheoreticalGroupController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::prefix('v1')->group(
    function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/validate-token', [AuthController::class, 'validateToken']);
    }
);

// Protected routes
// Commented out auth:sanctum middleware for testing purposes
Route::middleware('auth:sanctum')->group(function () {
    // Versioned routes
    Route::prefix('v1')->group(function () {
        // User profile and password routes
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
        Route::get('/user-list', [AuthController::class, 'index']);
        Route::put('/update/{id}', [AuthController::class, 'update']);
        Route::delete('/delete/{id}', [AuthController::class, 'delete']);

        // Admin-only routes
        // Excel Import routes
        Route::post('/upload-students', [StudentController::class, 'uploadStudents']);
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

        // Students CRUD
        Route::prefix('students')->group(function () {
            Route::get('/', [StudentController::class, 'index']);
            Route::get('/{id}', [StudentController::class, 'show']);
            Route::post('/', [StudentController::class, 'store']);
            Route::put('/{id}', [StudentController::class, 'update']);
            Route::delete('/{id}', [StudentController::class, 'destroy']);
        });

        // Courses routes
        Route::prefix('courses')->group(function () {
            Route::get('/', [CourseController::class, 'index']);
            Route::get('/{id}', [CourseController::class, 'show']);
            Route::get('/department/{departmentId}', [CourseController::class, 'showbyDepartment']);
            Route::post('/', [CourseController::class, 'store']);
            Route::put('/{id}', [CourseController::class, 'update']);
            Route::delete('/{id}', [CourseController::class, 'delete']);
        });

        // StudyPlan routes
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
        Route::prefix('theo_groups')->group(function () {
            Route::get('/', [TheoreticalGroupController::class, 'index']);
            Route::get('/{id}', [TheoreticalGroupController::class, 'show']);
            Route::post('/', [TheoreticalGroupController::class, 'store']);
            Route::put('/{id}', [TheoreticalGroupController::class, 'update']);
            Route::delete('/{id}', [TheoreticalGroupController::class, 'delete']);
        });

        // Lab Group routes
        Route::prefix('sub_groups')->group(function () {
            Route::get('/', [LabGroupController::class, 'index']);
            Route::get('/{id}', [LabGroupController::class, 'show']);
            Route::post('/', [LabGroupController::class, 'store']);
            Route::put('/{id}', [LabGroupController::class, 'update']);
            Route::delete('/{id}', [LabGroupController::class, 'delete']);
        });

        // Course Materials routes
        Route::prefix('course_materials')->group(function () {
            Route::get('/', [CourseMaterialController::class, 'index']);
            Route::get('/{id}', [CourseMaterialController::class, 'show']);
            Route::post('/', [CourseMaterialController::class, 'store']);
            Route::put('/{id}', [CourseMaterialController::class, 'update']);
            Route::delete('/{id}', [CourseMaterialController::class, 'delete']);
        });
    });
});
