<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        $query = Rental::with(['user', 'virtualWorld'])->orderBy('start_date', 'desc');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $rentals = $query->get();

        return view('admin.rental.index', compact('rentals', 'users', 'request'));
    }

    public function approveReturn($id)
    {
        $rental = Rental::with(['virtualWorld', 'penalties'])->findOrFail($id);
        $today = Carbon::today();
        $endDate = Carbon::parse($rental->end_date);

        // Hitung keterlambatan
        $lateDays = $endDate->lt($today) ? $endDate->diffInDays($today) : 0;
        $totalPenalty = $rental->penalties()->sum('amount'); // ambil total denda yg udah tercatat (kalau ada)

        // Tentukan status pengembalian
        $rental->status = $lateDays > 0 ? 'overdue' : 'returned';

        // Update data rental
        $rental->update([
            'return_requested' => false,
            'return_approved' => true,
            'returned_at' => $today,
            'total_penalty' => $totalPenalty,
            'payment_status' => $totalPenalty > 0 ? 'pending' : 'paid',
            'is_returned' => true,
        ]);

        // Update status dunia virtual jadi tersedia
        $rental->virtualWorld->update(['is_rented' => false]);

        return redirect()
            ->back()
            ->with(
                'success',
                $lateDays > 0
                    ? "Pengembalian disetujui, telat {$lateDays} hari. Denda sudah tercatat."
                    : "Pengembalian disetujui tanpa denda."
            );
    }


    public function print(Request $request)
    {
        $query = Rental::with(['user', 'virtualWorld']);

        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        $rentals = $query->get();
        $user = null;

        if ($request->user_id) {
            $user = User::find($request->user_id);
        }

        return view('admin.rental.print', compact('rentals', 'user'));
    }

    public function show($id)
    {
        $payment = Payment::with('penalty.rental.user')->findOrFail($id);
        return view('admin.rental.show', compact('payment'));
    }


    public function getData(Request $request)
    {
        $query = Rental::with(['user', 'virtualWorld', 'penalties.payment'])
            ->orderBy('start_date', 'desc');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $rentals = $query->get()->map(function ($rental) {
            $start = \Carbon\Carbon::parse($rental->start_date);
            $end = \Carbon\Carbon::parse($rental->end_date);
            $today = \Carbon\Carbon::today();

            $totalDays = $start->diffInDays($today);

            // Ambil penalty terakhir (jika ada)
            $penalty = $rental->penalties->sortByDesc('created_at')->first();
            $denda = $penalty?->amount ?? 0;
            $lateDays = $penalty?->days_overdue ?? 0;
            $isPaid = $penalty?->is_paid ?? false;
            $payment = $penalty?->payment;

            $status = match ($rental->status) {
                'ongoing' => $today->gt($end) ? 'Late' : 'Ongoing',
                'completed' => 'Completed',
                default => ucfirst($rental->status),
            };

            return [
                'id' => $rental->id,
                'user' => $rental->user->name,
                'virtualWorld' => $rental->virtualWorld->name,
                'code' => $rental->virtualWorld->code,
                'start' => $start->format('Y-m-d'),
                'end' => $end->format('Y-m-d'),
                'totalDays' => $totalDays,
                'status' => $status,
                'denda' => $denda,
                'lateDays' => $lateDays,
                'is_paid' => $isPaid,
                'payment' => $payment ? [
                    'id' => $payment->id,
                    'order_id' => $payment->order_id,
                    'amount' => $payment->amount,
                    'status' => $payment->status,
                ] : null,
                'return_requested' => $rental->return_requested,
                'rental_status' => $rental->status,
            ];
        });

        return response()->json(['data' => $rentals]);
    }
}
