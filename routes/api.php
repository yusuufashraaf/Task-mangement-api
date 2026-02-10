<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
Route::post('/tenants', [TenantController::class,'store']);

Route::post('/login', [AuthController::class,'login'])
    ->middleware('tenant');

Route::middleware(['tenant','auth:sanctum'])->group(function () {
    Route::post('/users', [UserController::class, 'store']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::apiResource('tasks', TaskController::class);
});