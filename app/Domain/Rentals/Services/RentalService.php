<?php

namespace App\Domain\Rentals\Services;

use App\Domain\Rentals\Repositories\RentalRepositoryInterface;
use App\Models\VirtualWorld;
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
        // Cek apakah user bisa menyewa
        if (!$this->rentalRepository->userCanRent($userId)) {
            throw new \Exception('Anda sudah mencapai batas maksimal 2 unit aktif.');
        }

        // Hitung durasi sewa
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $diffDays = $start->diffInDays($end); // termasuk hari pertama
        if ($diffDays > 5) {
            throw new \Exception('Maksimal masa pinjam adalah 5 hari. Jika lebih akan dikenakan denda.');
        }

        // Buat rental
        $rental = $this->rentalRepository->createRental([
            'user_id' => $userId,
            'virtual_world_id' => $virtualWorldId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'ongoing',
        ]);

        $virtualWorld = VirtualWorld::find($virtualWorldId);
        if ($virtualWorld) {
            $virtualWorld->is_rented = true;
            $virtualWorld->is_available = false;
            $virtualWorld->save();
        }

        return $rental;
    }
}
