@extends('admin.layouts.app')

@section('title', 'Detail Pembayaran Denda')

@section('content')
<div class="glow-card p-8 rounded-2xl max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-cyan-400">
            💳 Detail Pembayaran Denda
        </h2>
        <a href="{{ url()->previous() }}" 
           class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            ← Kembali
        </a>
    </div>

    {{-- Informasi Pembayaran --}}
    <div class="bg-gray-900 p-6 rounded-xl mb-6 border border-gray-700">
        <h3 class="text-lg font-semibold text-cyan-300 mb-3">Informasi Pembayaran</h3>
        <table class="w-full text-gray-300">
            <tr>
                <td class="py-2 w-48">Order ID</td>
                <td>: <span class="font-mono text-white">{{ $payment->order_id }}</span></td>
            </tr>
            <tr>
                <td class="py-2">Nominal</td>
                <td>: Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="py-2">Status</td>
                <td>
                    : 
                    @if($payment->status === 'settlement')
                        <span class="text-green-400 font-semibold">Berhasil</span>
                    @elseif($payment->status === 'pending')
                        <span class="text-yellow-400 font-semibold">Menunggu Pembayaran</span>
                    @else
                        <span class="text-red-400 font-semibold">{{ ucfirst($payment->status) }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="py-2">Tipe Pembayaran</td>
                <td>: {{ $payment->payment_type ?? '-' }}</td>
            </tr>
            <tr>
                <td class="py-2">Tanggal Transaksi</td>
                <td>: {{ $payment->created_at->format('d M Y H:i') }}</td>
            </tr>
        </table>
    </div>

    {{-- Informasi Denda --}}
    @if($payment->penalty)
    <div class="bg-gray-900 p-6 rounded-xl mb-6 border border-gray-700">
        <h3 class="text-lg font-semibold text-cyan-300 mb-3">Detail Denda</h3>
        <table class="w-full text-gray-300">
            <tr>
                <td class="py-2 w-48">Jumlah Denda</td>
                <td>: Rp {{ number_format($payment->penalty->amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="py-2">Hari Terlambat</td>
                <td>: {{ $payment->penalty->days_overdue }} Hari</td>
            </tr>
            <tr>
                <td class="py-2">Status Denda</td>
                <td>
                    : 
                    @if($payment->penalty->is_paid)
                        <span class="text-green-400 font-semibold">Sudah Dibayar</span>
                    @else
                        <span class="text-yellow-400 font-semibold">Belum Dibayar</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    @endif

    {{-- Informasi Rental --}}
    @if($payment->penalty && $payment->penalty->rental)
    <div class="bg-gray-900 p-6 rounded-xl mb-6 border border-gray-700">
        <h3 class="text-lg font-semibold text-cyan-300 mb-3">Data Rental Terkait</h3>
        <table class="w-full text-gray-300">
            <tr>
                <td class="py-2 w-48">Dunia Virtual</td>
                <td>: {{ $payment->penalty->rental->virtualWorld->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="py-2">Kode Unit</td>
                <td>: {{ $payment->penalty->rental->virtualWorld->code ?? '-' }}</td>
            </tr>
            <tr>
                <td class="py-2">Tanggal Mulai</td>
                <td>: {{ \Carbon\Carbon::parse($payment->penalty->rental->start_date)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td class="py-2">Tanggal Selesai</td>
                <td>: {{ \Carbon\Carbon::parse($payment->penalty->rental->end_date)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td class="py-2">Status Rental</td>
                <td>: {{ ucfirst($payment->penalty->rental->status) }}</td>
            </tr>
        </table>
    </div>
    @endif

    {{-- Informasi User --}}
    @if($payment->penalty && $payment->penalty->rental && $payment->penalty->rental->user)
    <div class="bg-gray-900 p-6 rounded-xl border border-gray-700">
        <h3 class="text-lg font-semibold text-cyan-300 mb-3">Data Pengguna</h3>
        <table class="w-full text-gray-300">
            <tr>
                <td class="py-2 w-48">Nama</td>
                <td>: {{ $payment->penalty->rental->user->name }}</td>
            </tr>
            <tr>
                <td class="py-2">Email</td>
                <td>: {{ $payment->penalty->rental->user->email }}</td>
            </tr>
        </table>
    </div>
    @endif
</div>
@endsection
