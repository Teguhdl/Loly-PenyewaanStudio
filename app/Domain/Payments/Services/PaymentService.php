<?php

namespace App\Domain\Payments\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Models\Penalty;
use Illuminate\Support\Str;

class PaymentService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Buat Payment + Penalty dan generate snap token langsung.
     * Mengembalikan array: success, penalty (model), payment (model), pay_route
     */
    public function createPenaltyPayment($rental, int $lateDays, int $amount)
    {
        $orderId = 'PENALTY-' . strtoupper(Str::random(10));

        // buat payment
        $payment = Payment::create([
            'order_id' => $orderId,
            'amount' => $amount,
            'status' => 'pending',
        ]);

        // buat penalty dan link ke payment
        $penalty = Penalty::create([
            'rental_id' => $rental->id,
            'days_overdue' => $lateDays,
            'amount' => $amount,
            'is_paid' => false,
            'payment_id' => $payment->id,
            'order_id' => $orderId,
        ]);

        // siapkan params untuk Snap
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $rental->user->name ?? 'User',
                'email' => $rental->user->email ?? 'example@mail.com',
            ],
            'item_details' => [
                [
                    'id' => $rental->id,
                    'price' => $rental->virtualWorld->price_per_day,
                    'quantity' => $lateDays,
                    'name' => 'Denda keterlambatan sewa ' . $rental->virtualWorld->name,
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $payment->snap_token = $snapToken;
            $payment->save();

            return [
                'success' => true,
                'penalty' => $penalty,
                'payment' => $payment,
                'pay_route' => route('user.rentals.payPenalty', ['penalty' => $penalty->id]),
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Error (createPenaltyPayment): ' . $e->getMessage());
            // rollback minimal: hapus payment & penalty
            $penalty->delete();
            $payment->delete();

            return [
                'success' => false,
                'message' => 'Gagal membuat token pembayaran: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Kembalikan atau buat snap token untuk payment (dipakai saat membuka halaman pembayaran)
     */
    public function ensureSnapToken(Payment $payment, $rental = null, $lateDays = 1)
    {
        if ($payment->snap_token) {
            return $payment->snap_token;
        }

        $orderId = $payment->order_id;
        $amount = $payment->amount;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => ($rental->user->name ?? 'User'),
                'email' => ($rental->user->email ?? 'example@mail.com'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $payment->snap_token = $snapToken;
            $payment->save();
            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans Error (ensureSnapToken): ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Tangani callback dari Midtrans (dipanggil oleh controller)
     * return array with success boolean and message
     */
    public function handleCallback($request)
    {
        $serverKey = config('midtrans.server_key');

        if ($request->has('signature_key')) {
            $grossAmount = number_format($request->gross_amount, 2, '.', '');
            $expectedSignature = hash('sha512', $request->order_id . $request->status_code . $grossAmount . $serverKey);

            if ($expectedSignature !== $request->signature_key) {
                Log::warning('Invalid signature', [
                    'order_id' => $request->order_id,
                    'expected' => $expectedSignature,
                    'received' => $request->signature_key,
                ]);
                return ['success' => false, 'message' => 'Invalid signature'];
            }
        } else {
            Log::info('Callback tanpa signature_key (kemungkinan hasil redirect atau status query)', [
                'order_id' => $request->order_id ?? '(unknown)'
            ]);
        }

        $payment = Payment::where('order_id', $request->order_id)->first();

        if (!$payment) {
            return ['success' => false, 'message' => 'Payment not found'];
        }

        $payment->update([
            'status' => $request->transaction_status,
            'payment_type' => $request->payment_type ?? $payment->payment_type,
            'response' => $request->all(),
        ]);

        $penalty = $payment->penalty ?? $payment->penalties()->first();

        if (!$penalty) {
            Log::warning('Payment found but no penalty linked for order_id: ' . $request->order_id);
            return ['success' => false, 'message' => 'Penalty not found for payment'];
        }

        if (in_array($request->transaction_status, ['settlement', 'capture'])) {
            $penalty->update([
                'is_paid' => true,
                'payment_id' => $payment->id,
            ]);
            if ($penalty->rental) {
                $penalty->rental->return_requested = true;
                $penalty->rental->save();
            }

            return ['success' => true, 'message' => 'Payment settled, penalty marked paid.'];
        }

        return ['success' => false, 'message' => 'Transaction status: ' . $request->transaction_status];
    }
}
