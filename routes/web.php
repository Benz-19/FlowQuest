<?php

use CustomRouter\Route;
use App\Http\Controllers\Pages\PagesController;
use App\Http\Controllers\Payments\PaymentsController;

require __DIR__ . '/../vendor/autoload.php';

// Landing Page
Route::get('/', [PagesController::class, 'renderLandingPage']);

// Authentication

//Register
Route::get('/register', [PagesController::class, 'renderRegisterPage']);
//Login
Route::get('/login', [PagesController::class, 'renderLoginPage']);
// User Role Selection
Route::get('/register-freelancer', [PagesController::class, 'renderFreelancerOnboardingPage']);
Route::get('/register-client', [PagesController::class, 'renderClientOnboardingPage']);
