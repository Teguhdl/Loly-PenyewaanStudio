<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Domain\Rentals\Services\RentalService;
use App\Domain\Payments\Services\PaymentService;
use App\Models\VirtualWorld;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Penalty;

use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Str;

class RentalUserController extends Controller
{
    protected $rentalService;
    protected $paymentService;

    public function __construct(RentalService $rentalService, PaymentService $paymentService)
    {
        $this->rentalService = $rentalService;
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        $virtualWorlds = VirtualWorld::with('categories')
            ->orderBy('is_rented', 'asc')
            ->get();

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

    public function history()
    {
        $rentals = Rental::with('virtualWorld')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.rentals.history', compact('rentals'));
    }

    public function requestReturn(Request $request, $id)
    {
        $rental = Rental::with('virtualWorld', 'user')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $start = Carbon::parse($rental->start_date);
        $end = Carbon::parse($rental->end_date);
        $today = Carbon::today();

        if ($today->gt($end)) {
            $lateDays = $today->diffInDays($end);
            $denda = $lateDays * $rental->virtualWorld->price_per_day;

            // buat payment + penalty (digabung di service)
            $result = $this->paymentService->createPenaltyPayment($rental, $lateDays, $denda);

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal membuat pembayaran denda.'
                ], 500);
            }

            // redirect ke halaman pembayaran (route ke penalty id)
            return response()->json([
                'success' => true,
                'type' => 'penalty_required',
                'message' => "Anda telat mengembalikan dan dikenakan denda sebesar Rp " . number_format($denda, 0, ',', '.'),
                'payment_url' => $result['pay_route'],
            ]);
        }

        // Tidak telat
        $rental->return_requested = true;
        $rental->save();

        return response()->json([
            'success' => true,
            'type' => 'return_requested',
            'message' => 'Permintaan pengembalian berhasil dikirim dan menunggu persetujuan admin.',
        ]);
    }

    /**
     * Tampilkan halaman pembayaran untuk penalty (menggunakan penalty id)
     */
    public function showPenaltyPayment($penaltyId)
    {
        $penalty = Penalty::with('rental.virtualWorld', 'payment', 'rental.user')
            ->findOrFail($penaltyId);

        // cek ownership
        if ($penalty->rental->user_id !== Auth::id()) {
            abort(403);
        }

        $payment = $penalty->payment;

        // pastikan snap token ada (bisa buat baru via service)
        $snapToken = $this->paymentService->ensureSnapToken($payment, $penalty->rental, $penalty->days_overdue);

        $amount = $penalty->amount;
        $lateDays = $penalty->days_overdue;

        return view('user.rentals.pay_penalty_gateway', compact('penalty', 'payment', 'amount', 'lateDays', 'snapToken'));
    }

    /**
     * Endpoint yang dipanggil dari client setelah snap selesai (jika Anda pakai client-side callback)
     * Akan memanggil service handleCallback untuk memproses.
     */
    public function midtransCallback(Request $request)
    {
        // Use PaymentService to verify and process
        $result = $this->paymentService->handleCallback($request);

        if ($result['success']) {
            return response()->json(['success' => true, 'message' => $result['message'] ?? 'OK']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] ?? 'Failed'], 400);
    }
}