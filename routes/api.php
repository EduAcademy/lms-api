<?php

use App\Http\Controllers\Department\DepartmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/register",[AuthController::class,"register"]);
Route::post("/login",[AuthController::class,"login"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/getDepartment', [DepartmentController::class, 'index']);
    Route::post('/createDepartment', [DepartmentController::class, 'createDepartment']);
});