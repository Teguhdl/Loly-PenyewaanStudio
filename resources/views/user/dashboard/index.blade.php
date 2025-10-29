@extends('user.layouts.app')

@section('content')
<div class="text-center mb-10">
    <h2 class="text-3xl font-bold neon-text mb-2">Selamat Datang, {{ $user->name }}</h2>
    <p class="text-gray-400">Ringkasan aktivitas penyewaan Anda di dunia virtual 🌌</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <div class="glow-card p-6 rounded-2xl text-center">
        <h2 class="text-lg font-semibold text-cyan-300 mb-2">Total Peminjaman</h2>
        <p class="text-4xl font-bold">{{ $summary->totalRentals ?? 0 }}</p>
    </div>

    <div class="glow-card p-6 rounded-2xl text-center">
        <h2 class="text-lg font-semibold text-cyan-300 mb-2">Sedang Berjalan</h2>
        <p class="text-4xl font-bold text-yellow-400">{{ $summary->ongoing ?? 0 }}</p>
    </div>

    <div class="glow-card p-6 rounded-2xl text-center">
        <h2 class="text-lg font-semibold text-cyan-300 mb-2">Terlambat</h2>
        <p class="text-4xl font-bold text-red-400">{{ $summary->overdue ?? 0 }}</p>
    </div>

    <div class="glow-card p-6 rounded-2xl text-center">
        <h2 class="text-lg font-semibold text-cyan-300 mb-2">Selesai</h2>
        <p class="text-4xl font-bold text-green-400">{{ $summary->returned ?? 0 }}</p>
    </div>
</div>
@endsection
