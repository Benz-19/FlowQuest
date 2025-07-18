<?php

use App\Http\Controllers\Api\UserDataApiController;
use App\Http\Controllers\Auth\AuthController;
use CustomRouter\Route;
use App\Http\Controllers\Pages\PagesController;
use App\Http\Controllers\Payments\PaymentsController;

require __DIR__ . '/../vendor/autoload.php';

// Landing Page
Route::get('/', [PagesController::class, 'renderLandingPage']);

// Authentication

//Register
Route::get('/register', [PagesController::class, 'renderRegisterPage']);
Route::post('/process-registration', [AuthController::class, 'register']);
// Example in your routing file
Route::get('/api/user-email-check', [UserDataApiController::class, 'getData']);
//Login
Route::get('/login', [PagesController::class, 'renderLoginPage']);
// User Role Selection
Route::get('/register-freelancer', [PagesController::class, 'renderFreelancerOnboardingPage']);
Route::get('/register-client', [PagesController::class, 'renderClientOnboardingPage']);

// Test page
Route::get('/test', [PagesController::class, 'renderLandingPage']);
Route::get('/test-pages', [PagesController::class, 'renderTestingPage']);
