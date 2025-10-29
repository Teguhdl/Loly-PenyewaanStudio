<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Domain\Rentals\Services\RentalService;
use App\Models\VirtualWorld;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalUserController extends Controller
{
    protected $rentalService;

    public function __construct(RentalService $rentalService)
    {
        $this->rentalService = $rentalService;
    }

    public function index()
    {
        $virtualWorlds = VirtualWorld::with('categories')->get();
        return view('user.rentals.index', compact('virtualWorlds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'virtual_world_id' => 'required|exists:virtual_worlds,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            $this->rentalService->rentVirtualWorld(
                Auth::id(),
                $request->virtual_world_id,
                $request->start_date,
                $request->end_date
            );

            return redirect()->back()->with('success', 'Peminjaman berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
