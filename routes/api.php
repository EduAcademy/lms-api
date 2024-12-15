<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Department\DepartmentController;
use App\Http\Controllers\Instructor\InstructorController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User profile and password routes
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    // Students - Import Students from Excel
    Route::post('/upload-students', [StudentController::class, 'uploadStudents']);
    Route::post('/upload-depts', [DepartmentController::class, 'createDepartment']);

    // Versioned routes
    Route::prefix('v1')->group(function () {
        // Admin-only routes
        
        Route::middleware(['role:admin'])->group(function () {
            // Department routes
            Route::get('/departments', [DepartmentController::class, 'index']);
            Route::post('/departments', [DepartmentController::class, 'store']);
            Route::put('/departments/{id}', [DepartmentController::class, 'update']);
            Route::delete('/departments/{id}', [DepartmentController::class, 'destroy']);

            // Instructors CRUD
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
        });

        // Student-specific routes
        Route::middleware(['role:student'])->group(function () {
            Route::get('/study-plans', [StudentController::class, 'getStudyPlans']);
        });
    });
});
