<?php

use App\Http\Controllers\Pages\PagesController;
use CustomRouter\Route;

Route::get('/', function () {
    require __DIR__ . '/../resources/Views/Pages/landing.php';
});
Route::get('/flowquest/public/', [PagesController::class, 'renderLandingPage']);
