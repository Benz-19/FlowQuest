<?php

namespace App\Services\Dashboard;

class FreelancerDashboardService extends AbstractDashboardService
{
    public function getMetrics(): array
    {
        return [
            'total_projects' => 10,
            'completed_projects' => 7,
            'active_projects' => 3
        ];
    }

    public function getRecentActivity(): array
    {
        return [
            ['project' => 'Website Development', 'status' => 'In Progress'],
            ['project' => 'Mobile App Design', 'status' => 'Completed']
        ];
    }

    public function getIncomeAnalytics(): array
    {
        return [
            'total_income' => 1500,
            'last_month' => 500,
            'this_month' => 1000
        ];
    }
}
