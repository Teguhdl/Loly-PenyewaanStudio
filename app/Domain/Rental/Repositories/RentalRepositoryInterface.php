<?php

namespace App\Domain\Rentals\Repositories;

interface RentalRepositoryInterface
{
    public function getUserActiveRentals($userId);
    public function createRental(array $data);
    public function userCanRent($userId): bool;
}
