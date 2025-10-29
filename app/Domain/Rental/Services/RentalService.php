<?php

namespace App\Domain\Rentals\Services;

use App\Domain\Rentals\Repositories\RentalRepositoryInterface;
use Carbon\Carbon;

class RentalService
{
    private $rentalRepository;

    public function __construct(RentalRepositoryInterface $rentalRepository)
    {
        $this->rentalRepository = $rentalRepository;
    }

    public function rentVirtualWorld($userId, $virtualWorldId, $startDate, $endDate)
    {
        if (!$this->rentalRepository->userCanRent($userId)) {
            throw new \Exception('Anda sudah mencapai batas maksimal 2 unit aktif.');
        }

        $diffDays = Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));
        if ($diffDays > 5) {
            throw new \Exception('Maksimal masa pinjam adalah 5 hari.');
        }
        
        return $this->rentalRepository->createRental([
            'user_id' => $userId,
            'virtual_world_id' => $virtualWorldId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'ongoing',
        ]);
    }
}
