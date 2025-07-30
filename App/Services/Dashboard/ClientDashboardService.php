<?php

namespace App\Services\Dashboard;

use App\Services\Dashboard\AbstractDashboardService;

class ClientDashboardService extends AbstractDashboardService
{
    public function getMetrics(): array
    {
        $totalProjects = $this->db->fetchColumn(
            "SELECT COUNT(*) FROM projects WHERE client_id = :client_id",
            [':client_id' => $this->userId]
        );

        $completedProjects = $this->db->fetchColumn(
            "SELECT COUNT(*) FROM projects WHERE client_id = :client_id AND status = 'completed'",
            [':client_id' => $this->userId]
        );

        $activeProjects = $this->db->fetchColumn(
            "SELECT COUNT(*) FROM projects WHERE client_id = :client_id AND status = 'in_progress'",
            [':client_id' => $this->userId]
        );

        return [
            'total_projects'    => (int) $totalProjects,
            'completed_projects' => (int) $completedProjects,
            'active_projects'   => (int) $activeProjects,
        ];
    }

    public function getRecentActivity(): array
    {
        return $this->db->fetchAllData(
            "SELECT title AS project, status
             FROM projects
             WHERE client_id = :client_id
             ORDER BY updated_at DESC
             LIMIT 5",
            [':client_id' => $this->userId]
        );
    }

    public function getIncomeAnalytics(): array
    {
        $totalSpent = $this->db->fetchColumn(
            "SELECT SUM(amount) FROM client_payments WHERE client_id = :client_id",
            [':client_id' => $this->userId]
        ) ?? 0;

        $lastMonthSpent = $this->db->fetchColumn(
            "SELECT SUM(amount) FROM client_payments
             WHERE client_id = :client_id
             AND MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)",
            [':client_id' => $this->userId]
        ) ?? 0;

        $thisMonthSpent = $this->db->fetchColumn(
            "SELECT SUM(amount) FROM client_payments
             WHERE client_id = :client_id
             AND MONTH(created_at) = MONTH(CURRENT_DATE)",
            [':client_id' => $this->userId]
        ) ?? 0;

        return [
            'total_spent'   => (float) $totalSpent,
            'last_month'    => (float) $lastMonthSpent,
            'this_month'    => (float) $thisMonthSpent,
        ];
    }
}
