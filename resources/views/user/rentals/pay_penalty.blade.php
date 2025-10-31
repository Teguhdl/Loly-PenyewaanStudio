@extends('user.layouts.app')

@section('title', 'Pembayaran Denda')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-white mb-6">💸 Pembayaran Denda Keterlambatan</h1>

    <div class="bg-gray-900 rounded-2xl shadow-lg p-6 text-gray-300 max-w-lg mx-auto">
        <h2 class="text-xl text-cyan-400 font-semibold mb-4">{{ $rental->virtualWorld->name }}</h2>

        <p>Durasi keterlambatan: <span class="text-yellow-400 font-bold">{{ $lateDays }} hari</span></p>
        <p>Denda per hari: Rp{{ number_format($rental->virtualWorld->price_per_day, 0, ',', '.') }}</p>
        <p>Total Denda: <span class="text-red-400 font-bold">Rp{{ number_format($denda, 0, ',', '.') }}</span></p>

        <form method="POST" action="{{ route('user.rentals.processPenalty', $rental->id) }}" class="mt-6">
            @csrf
            <input type="hidden" name="amount" value="{{ $denda }}">
            <input type="hidden" name="lateDays" value="{{ $lateDays }}">
            <button type="submit" class="w-full bg-cyan-500 hover:bg-cyan-600 text-white py-2 rounded-lg font-semibold">
                Bayar Sekarang
            </button>
        </form>
    </div>
</div>
@endsection
