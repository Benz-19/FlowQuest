<?php

use CustomRouter\Route;
use App\Http\Controllers\Api\UserDataApiController;

require __DIR__ . '/../vendor/autoload.php';

// User-related API routes
Route::get('/api/user-email-check', [UserDataApiController::class, 'checkEmail']);
Route::post('/api/send-verification-code', [UserDataApiController::class, 'sendCode']);
Route::post('/api/verify-code', [UserDataApiController::class, 'verifyCode']);
Route::post('/api/user-register', [UserDataApiController::class, 'registerUser']);
