<?php

use CustomRouter\Route;
use App\Http\Controllers\Pages\PagesController;

require __DIR__ . '/../vendor/autoload.php';

Route::get('/', function () {
    require __DIR__ . '/../resources/Views/Pages/landing.php';
});

// Route::get('/test', function () {
//     require __DIR__ . '/../test/landing_test.php';
// });
Route::get('/test', [PagesController::class, 'renderLandingPage']);
// Route::get('/flowquest/public/', [PagesController::class, 'renderLandingPage']);
