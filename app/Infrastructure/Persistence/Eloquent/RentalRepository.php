<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Rentals\Repositories\RentalRepositoryInterface;
use App\Models\Rental;

class RentalRepository implements RentalRepositoryInterface
{
    public function getUserActiveRentals($userId)
    {
        return Rental::where('user_id', $userId)
            ->whereIn('status', ['ongoing', 'overdue'])
            ->count();
    }

    public function userCanRent($userId): bool
    {
        return $this->getUserActiveRentals($userId) < 2;
    }

    public function createRental(array $data)
    {
        return Rental::create($data);
    }
}
