<?php

use App\Http\Controllers\Api\UserDataApiController;
use App\Http\Controllers\Auth\AuthController;
use CustomRouter\Route;
use App\Http\Controllers\Pages\PagesController;
use App\Http\Controllers\Payments\PaymentsController;
use App\Services\Auth\AuthService;

require __DIR__ . '/../vendor/autoload.php';

// Landing Page
Route::get('/', [PagesController::class, 'renderLandingPage']);

// Authentication

//Register
Route::get('/register', [PagesController::class, 'renderRegisterPage']);
Route::post('/process-registration', [AuthController::class, 'register']);

//Login
Route::get('/login', [PagesController::class, 'renderLoginPage']);
Route::get('/process-login', [AuthService::class, 'login']);
// User Role Selection
Route::get('/register-freelancer', [PagesController::class, 'renderFreelancerOnboardingPage']);
Route::get('/register-client', [PagesController::class, 'renderClientOnboardingPage']);


// Admin Functionalities
Route::get('/admin-dashboard', [PagesController::class, 'renderAdminDashboardPage']);

// Client Functionalities
Route::get('/client-dashboard', [PagesController::class, 'renderClientDashboardPage']);

// Freelancer Functionalities
Route::get('/freelancer-dashboard', [PagesController::class, 'renderFreelancerDashboardPage']);
// Test page
Route::get('/test', [PagesController::class, 'renderLandingPage']);
Route::get('/test-pages', [PagesController::class, 'renderTestingPage']);
