<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Services\Dashboard\AdminDashboardService;
use App\Services\Dashboard\ClientDashboardService;
use App\Services\Dashboard\FreelancerDashboardService;

class DashboardController
{
    protected $userService;

    public function __construct(string $userType, $userId)
    {
        $this->userService = match ($userType) {
            'freelancer' => new FreelancerDashboardService($userId),
            'client'     => new ClientDashboardService($userId),
            'admin'      => new AdminDashboardService($userId),
            default      => throw new \Exception("Invalid user type: {$userType} at DashboardController")
        };
    }

    public function getDashboardData()
    {
        $data = [
            'metrics' => $this->userService->getMetrics(),
            'recent_activity' => $this->userService->getRecentActivity(),
            'income_analytics' => $this->userService->getIncomeAnalytics(),
            'user_data' => $this->userService->getUserData()
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
