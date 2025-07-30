<?php

namespace App\Services\Dashboard\Interfaces;

interface DashboardInterface
{
    public function getMetrics(): array;
    public function getRecentActivity(): array;
    public function getIncomeAnalytics(): array;
}
