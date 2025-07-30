<?php

namespace App\Services\Dashboard;

use App\Services\Dashboard\AbstractDashboardService;

class AdminDashboardService extends AbstractDashboardService
{
    public function getMetrics(): array
    {
        $totalUsers = $this->db->fetchColumn("SELECT COUNT(*) FROM users");
        $totalProjects = $this->db->fetchColumn("SELECT COUNT(*) FROM projects");
        $totalRevenue = $this->db->fetchColumn("SELECT SUM(amount) FROM payments") ?? 0;

        return [
            'total_users'    => (int) $totalUsers,
            'total_projects' => (int) $totalProjects,
            'total_revenue'  => (float) $totalRevenue,
        ];
    }

    public function getRecentActivity(): array
    {
        return $this->db->fetchAllData(
            "SELECT p.title AS project, u.username AS freelancer, c.username AS client, p.status
             FROM projects p
             JOIN users u ON p.freelancer_id = u.id
             JOIN users c ON p.client_id = c.id
             ORDER BY p.updated_at DESC
             LIMIT 5"
        );
    }

    public function getIncomeAnalytics(): array
    {
        $totalIncome = $this->db->fetchColumn("SELECT SUM(amount) FROM payments") ?? 0;

        $lastMonthIncome = $this->db->fetchColumn(
            "SELECT SUM(amount) FROM payments
             WHERE MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)"
        ) ?? 0;

        $thisMonthIncome = $this->db->fetchColumn(
            "SELECT SUM(amount) FROM payments
             WHERE MONTH(created_at) = MONTH(CURRENT_DATE)"
        ) ?? 0;

        return [
            'total_income'  => (float) $totalIncome,
            'last_month'    => (float) $lastMonthIncome,
            'this_month'    => (float) $thisMonthIncome,
        ];
    }
}
