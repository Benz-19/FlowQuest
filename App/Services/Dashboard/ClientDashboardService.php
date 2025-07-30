<?php

namespace App\Services\Dashboard;

class ClientDashboardService extends AbstractDashboardService
{
    public function getMetrics(): array
    {
        return [
            'total_jobs_posted' => 8,
            'active_jobs' => 2,
            'completed_jobs' => 6,
        ];
    }

    public function getRecentActivity(): array
    {
        return [
            ['activity' => 'Hired a freelancer', 'timestamp' => '2025-07-28 12:00:00'],
            ['activity' => 'Reviewed a proposal', 'timestamp' => '2025-07-27 16:00:00'],
        ];
    }

    public function getIncomeAnalytics(): array
    {
        return [
            'total_spent' => 7000,
            'last_month_spent' => 2500,
            'pending_invoices' => 400,
        ];
    }
}
