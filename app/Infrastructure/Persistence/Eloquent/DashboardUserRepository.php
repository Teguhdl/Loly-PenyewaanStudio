<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Dashboard\Repositories\DashboardUserRepositoryInterface;
use App\Models\Rental;

class DashboardUserRepository implements DashboardUserRepositoryInterface
{
    public function getUserRentalSummary(int $userId): array
    {
        $rentals = Rental::where('user_id', $userId)->get();

        return [
            'total_rentals' => $rentals->count(),
            'ongoing' => $rentals->where('status', 'ongoing')->count(),
            'overdue' => $rentals->where('status', 'overdue')->count(),
            'returned' => $rentals->where('status', 'returned')->count(),
        ];
    }
}
