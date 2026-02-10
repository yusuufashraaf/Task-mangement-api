<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::post('/tenants', [TenantController::class,'store']);

Route::post('/login', [AuthController::class,'login'])
    ->middleware('tenant');

Route::middleware(['tenant','auth:sanctum'])->group(function () {
    Route::apiResource('tasks', TaskController::class);
});