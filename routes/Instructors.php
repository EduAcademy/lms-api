<?php

use App\Http\Controllers\Instructor\InstructorController;
use Illuminate\Support\Facades\Route;

Route::prefix('instructors')->group(function () {
    Route::get('/', [InstructorController::class, 'index']);
    Route::get('/{id}', [InstructorController::class, 'show']);
    Route::post('/', [InstructorController::class, 'store']);
    Route::put('/{id}', [InstructorController::class, 'update']);
    Route::delete('/{id}', [InstructorController::class, 'destroy']);
});
