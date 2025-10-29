<?php

namespace App\Domain\Dashboard\Services;

use App\Domain\Dashboard\Repositories\DashboardUserRepositoryInterface;
use App\Domain\Dashboard\Entities\DashboardUserEntity;

class DashboardUserService
{
    protected $repository;

    public function __construct(DashboardUserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getSummaryForUser(int $userId): DashboardUserEntity
    {
        $data = $this->repository->getUserRentalSummary($userId);

        return new DashboardUserEntity(
            $data['total_rentals'],
            $data['ongoing'],
            $data['overdue'],
            $data['returned']
        );
    }
}
