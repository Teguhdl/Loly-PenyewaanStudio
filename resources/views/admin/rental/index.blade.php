@extends('admin.layouts.app')

@section('title', 'Daftar Rental Dunia Virtual')

@section('content')
<div class="glow-card p-8 rounded-2xl max-w-8xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl text-cyan-400 font-bold">Daftar Rental Dunia Virtual</h2>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-600 text-white rounded">{{ session('success') }}</div>
    @endif

    <table class="w-full text-left table-auto border-collapse border border-gray-700">
        <thead class="bg-gray-800 text-cyan-400">
            <tr>
                <th class="px-4 py-2 border border-gray-600">No</th>
                <th class="px-4 py-2 border border-gray-600">User</th>
                <th class="px-4 py-2 border border-gray-600">Dunia Virtual</th>
                <th class="px-4 py-2 border border-gray-600">Kode Unit</th>
                <th class="px-4 py-2 border border-gray-600">Tanggal Mulai</th>
                <th class="px-4 py-2 border border-gray-600">Batas Pengembalian</th>
                <th class="px-4 py-2 border border-gray-600">Total Lama Peminjaman</th>
                <th class="px-4 py-2 border border-gray-600">Status</th>
                <th class="px-4 py-2 border border-gray-600">Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentals as $rental)
            @php
                $start = \Carbon\Carbon::parse($rental->start_date);
                $end = \Carbon\Carbon::parse($rental->end_date);
                $today = \Carbon\Carbon::today();
                $totalDays = $start->diffInDays($today);

                $lateDays = 0;
                $denda = 0;
                if($today->gt($end)){
                    $lateDays = $today->diffInDays($end);
                    $denda = $lateDays * $rental->virtualWorld->price_per_day;
                }

                $status = match($rental->status) {
                    'ongoing' => $today->gt($end) ? 'Late' : 'Ongoing',
                    'completed' => 'Completed',
                    default => $rental->status
                };
            @endphp
            <tr class="bg-gray-900 hover:bg-gray-800 text-gray-300">
                <td class="px-4 py-2 border border-gray-700">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 border border-gray-700">{{ $rental->user->name }}</td>
                <td class="px-4 py-2 border border-gray-700">{{ $rental->virtualWorld->name }}</td>
                <td class="px-4 py-2 border border-gray-700">{{ $rental->virtualWorld->code }}</td>
                <td class="px-4 py-2 border border-gray-700">{{ $start->format('Y-m-d') }}</td>
                <td class="px-4 py-2 border border-gray-700">{{ $end->format('Y-m-d') }}</td>
                <td class="px-4 py-2 border border-gray-700">{{ $totalDays }} Hari</td>
                <td class="px-4 py-2 border border-gray-700">{{ $status }}</td>
                <td class="px-4 py-2 border border-gray-700">
                    @if($denda > 0)
                        Rp. {{ number_format($denda,0,',','.') }} ({{ $lateDays }} Hari Terlambat)
                    @else
                        Rp. 0
                    @endif
                </td>
            </tr>
            @endforeach
            @if($rentals->isEmpty())
            <tr>
                <td colspan="9" class="px-4 py-2 text-center text-gray-400">Belum ada data rental.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
