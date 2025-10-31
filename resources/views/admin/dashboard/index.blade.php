@extends('admin.layouts.app')

@section('content')
<div class="grid md:grid-cols-3 gap-6 mb-6">
    <div class="glow-card p-6 rounded-2xl text-center">
        <h2 class="text-xl font-semibold text-cyan-300">Total Users</h2>
        <p class="text-4xl font-bold mt-3">{{ $summary['total_users'] }}</p>
    </div>

    <div class="glow-card p-6 rounded-2xl text-center">
        <h2 class="text-xl font-semibold text-cyan-300">Admins</h2>
        <p class="text-4xl font-bold mt-3">{{ $summary['total_admins'] }}</p>
    </div>

    <div class="glow-card p-6 rounded-2xl text-center">
        <h2 class="text-xl font-semibold text-cyan-300">Members</h2>
        <p class="text-4xl font-bold mt-3">{{ $summary['total_members'] }}</p>
    </div>
</div>

{{-- Notifikasi Rental Terbaru --}}
<div class="glow-card p-6 rounded-2xl">
    <h2 class="text-xl font-semibold text-cyan-300 mb-4">📌 Rental Terbaru / Peminjaman Aktif</h2>
    @if($summary['recent_rentals']->isEmpty())
        <p class="text-gray-400">Tidak ada peminjaman baru.</p>
    @else
        <ul class="space-y-3">
            @foreach($summary['recent_rentals'] as $rental)
            <li class="bg-gray-900 p-3 rounded flex justify-between items-center hover:bg-gray-800 transition">
                <div>
                    <span class="font-semibold text-cyan-400">{{ $rental->user->name }}</span>
                    <span class="text-gray-300">menyewa</span>
                    <span class="font-semibold text-cyan-400">{{ $rental->virtualWorld->name }}</span>
                    @if($rental->return_requested)
                        <span class="bg-yellow-500 text-gray-900 px-2 py-0.5 text-xs rounded ml-2">Pengembalian</span>
                    @endif
                </div>
                <div class="text-sm text-gray-400">
                    Mulai: {{ \Carbon\Carbon::parse($rental->start_date)->format('Y-m-d') }}
                </div>
            </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
