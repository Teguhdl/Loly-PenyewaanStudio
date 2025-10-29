<?php

namespace App\Domain\Dashboard\Repositories;

interface DashboardUserRepositoryInterface
{
    public function getUserRentalSummary(int $userId): array;
}
