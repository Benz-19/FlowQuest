<?php
namespace App\Services\Api;

use App\Http\Controllers\Api\BaseApiController;

class BaseApiService{
    public function loadUserDashboard(){
     $user = $_SESSION['user_details'] ?? null;

    if (!$user) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    $controlller = new BaseApiController();
    $controlller->loadDashboardData($user);
    }
}