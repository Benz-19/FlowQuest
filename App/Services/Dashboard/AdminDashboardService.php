<?php

namespace App\Services\Dashboard;

class AdminDashboardService extends AbstractDashboardService
{
    public function getMetrics(): array
    {
        return [
            'total_users' => 150,
            'active_users' => 120,
            'banned_users' => 5,
        ];
    }

    public function getRecentActivity(): array
    {
        return [
            ['activity' => 'Reviewed new freelancer signup', 'timestamp' => '2025-07-28 09:00:00'],
            ['activity' => 'Suspended a client account', 'timestamp' => '2025-07-27 14:30:00'],
        ];
    }

    public function getIncomeAnalytics(): array
    {
        return [
            'total_platform_revenue' => 25000,
            'last_month_revenue' => 5000,
            'pending_payouts' => 800,
        ];
    }
}
