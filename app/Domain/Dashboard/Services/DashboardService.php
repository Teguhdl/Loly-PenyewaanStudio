<?php

namespace App\Domain\Dashboard\Services;

use App\Models\User;
use App\Models\Rental;

class DashboardService
{
    public function getSummary(): array
    {
      $summary = [
            'total_users' => User::where('role','user')->count(),
            'total_admins' => User::where('role','admin')->count(),
            'total_members' => User::where('role','member')->count(),
        ];

        $recentRentals = Rental::with(['user','virtualWorld'])
            ->where('status', 'ongoing')
            ->orWhere('return_requested', true)
            ->orderBy('start_date','desc')
            ->take(5)
            ->get();

        $summary['recent_rentals'] = $recentRentals;

        return $summary;


    }
    
}
