<?php
if (!session_start()) {
    session_start();
}

use CustomRouter\Route;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../routes/web.php';

Route::dispatch();
