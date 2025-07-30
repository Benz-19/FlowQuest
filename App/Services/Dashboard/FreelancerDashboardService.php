<?php

namespace App\Services\Dashboard;

use App\Services\Dashboard\AbstractDashboardService;

class FreelancerDashboardService extends AbstractDashboardService
{
    public function getMetrics(): array
    {
        // Total projects
        $totalProjects = $this->db->fetchColumn(
            "SELECT COUNT(*) FROM projects WHERE freelancer_id = :freelancer_id",
            [':freelancer_id' => $this->userId]
        );

        // Completed projects
        $completedProjects = $this->db->fetchColumn(
            "SELECT COUNT(*) FROM projects WHERE freelancer_id = :freelancer_id AND status = 'completed'",
            [':freelancer_id' => $this->userId]
        );

        // Active projects
        $activeProjects = $this->db->fetchColumn(
            "SELECT COUNT(*) FROM projects WHERE freelancer_id = :freelancer_id AND status = 'in_progress'",
            [':freelancer_id' => $this->userId]
        );

        return [
            'total_projects' => $totalProjects ?? 0,
            'completed_projects' => $completedProjects ?? 0,
            'active_projects' => $activeProjects ?? 0
        ];
    }

    public function getRecentActivity(): array
    {
        return $this->db->fetchAllData(
            "SELECT title AS project, status
             FROM projects
             WHERE freelancer_id = :freelancer_id
             ORDER BY updated_at DESC
             LIMIT 5",
            [':freelancer_id' => $this->userId]
        ) ?? [];
    }

    public function getIncomeAnalytics(): array
    {
        // Total income
        $totalIncome = $this->db->fetchColumn(
            "SELECT SUM(amount) FROM payments WHERE freelancer_id = :freelancer_id",
            [':freelancer_id' => $this->userId]
        );

        // Last month income
        $lastMonthIncome = $this->db->fetchColumn(
            "SELECT SUM(amount) FROM payments
             WHERE freelancer_id = :freelancer_id
             AND MONTH(payment_date) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)",
            [':freelancer_id' => $this->userId]
        );

        // This month income
        $thisMonthIncome = $this->db->fetchColumn(
            "SELECT SUM(amount) FROM payments
             WHERE freelancer_id = :freelancer_id
             AND MONTH(payment_date) = MONTH(CURRENT_DATE)
             AND YEAR(payment_date) = YEAR(CURRENT_DATE)",
            [':freelancer_id' => $this->userId]
        );

        return [
            'total_income' => $totalIncome ?? 0,
            'last_month' => $lastMonthIncome ?? 0,
            'this_month' => $thisMonthIncome ?? 0
        ];
    }
}
