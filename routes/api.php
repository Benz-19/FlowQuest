<?php

use CustomRouter\Route;
use App\Http\Controllers\Api\UserDataApiController;

require __DIR__ . '/../vendor/autoload.php';

Route::get('/api/user-email-check', [UserDataApiController::class, 'getData']);
Route::get('/api/send-verification-code', [UserDataApiController::class, 'postData']);
Route::post('/api/send-verification-code', [UserDataApiController::class, 'postData']);
Route::get('/api/verify-code', [UserDataApiController::class, 'getData']);
Route::post('/api/verify-code', [UserDataApiController::class, 'postData']);
Route::post('/api/user-register', [UserDataApiController::class, 'postData']);
