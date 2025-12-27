<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api\Dashboard\DashboardController;

class BaseApiController{

    public function loadDashboardData(array $user){
        
    $controller = new DashboardController($user['user_type'], $user['id']);
    $controller->getDashboardData();
    }
}