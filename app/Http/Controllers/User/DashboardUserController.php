<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Domain\Dashboard\Services\DashboardUserService;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardUserService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $user = Auth::user();
        $summary = $this->dashboardService->getSummaryForUser($user->id);

        return view('user.dashboard.index', compact('summary', 'user'));
    }
}
