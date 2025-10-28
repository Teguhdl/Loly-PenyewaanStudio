<?php

namespace App\Domain\Dashboard\Services;

use App\Models\User;

class DashboardService
{
    public function getSummary(): array
    {
        return [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_members' => User::where('role', 'user')->count(),
        ];
    }
}
