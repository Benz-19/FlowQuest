<?php

namespace App\Services\Dashboard;

use App\Models\DB;
use App\Services\Dashboard\interfaces\DashboardInterface;

abstract class AbstractDashboardService implements DashboardInterface
{
    protected DB $db;
    protected int $userId;

    public function __construct(int $userId)
    {
        $this->db = new DB();
        $this->userId = $userId;
    }

    /**
     * Common method to format dates or transform results.
     */
    protected function formatDate(string $date): string
    {
        return date('d-m-Y', strtotime($date));
    }

    /**
     * Default implementation: empty metrics (to be overridden by subclasses).
     */
    public function getMetrics(): array
    {
        return [];
    }

    /**
     * Default implementation: empty activity (to be overridden by subclasses).
     */
    public function getRecentActivity(): array
    {
        return [];
    }

    /**
     * Default implementation: empty income analytics (to be overridden by subclasses).
     */
    public function getIncomeAnalytics(): array
    {
        return [];
    }
}
