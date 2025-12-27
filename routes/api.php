<?php

use CustomRouter\Route;
use App\Http\Controllers\Api\UserDataApiController;
use App\Http\Controllers\Api\Dashboard\DashboardController;
use App\Services\Api\BaseApiService;

// require __DIR__ . '/../vendor/autoload.php';

// User-related API routes
Route::get('/api/user-email-check', [UserDataApiController::class, 'checkEmail']);
Route::post('/api/send-verification-code', [UserDataApiController::class, 'sendCode']);
Route::post('/api/verify-code', [UserDataApiController::class, 'verifyCode']);
Route::post('/api/user-register', [UserDataApiController::class, 'registerUser']);
Route::post('/api/update-user-password', [UserDataApiController::class, 'updatePassword']);
Route::post('/api/send-password-reset-verification-code', [UserDataApiController::class, 'passwordReset']);

// Dashboard routes
Route::get('/api/dashboard', [BaseApiService::class, 'loadUserDashboard']);

