<?php

use App\Http\Controllers\Department\DepartmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\StudentController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [ AuthController::class, 'register']);
Route::post("/login", [ AuthController::class,"login"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});


Route::post('/upload-students', [StudentController::class, 'uploadStudents']);
Route::post('/upload-depts', [DepartmentController::class, 'createDepartment']);

Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    // Admin-only routes
    Route::middleware(['role:admin'])->group(function () { 
        Route::get('/getDepartment', [DepartmentController::class, 'index']);
    });

    // Student-only routes
    Route::middleware(['role:student'])->group(function () {
        Route::post('/createDepartment', [DepartmentController::class, 'createDepartment']);
    });

    // Instructor-only routes

});