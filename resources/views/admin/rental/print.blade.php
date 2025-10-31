<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Dunia Virtual</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fff; color: #000; }
        h2, h4 { text-align: center; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #eee; }
        .text-center { text-align: center; }
        .mt-2 { margin-top: 10px; }
    </style>
</head>
<body onload="window.print()">

    <h2>Laporan Peminjaman Dunia Virtual</h2>
    @if($user)
        <h4>Nama User: {{ $user->name }}</h4>
    @else
        <h4>Semua User</h4>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Dunia Virtual</th>
                <th>Kode Unit</th>
                <th>Tanggal Mulai</th>
                <th>Batas Pengembalian</th>
                <th>Total Lama</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rentals as $rental)
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
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $rental->user->name }}</td>
                    <td>{{ $rental->virtualWorld->name }}</td>
                    <td>{{ $rental->virtualWorld->code }}</td>
                    <td>{{ $start->format('Y-m-d') }}</td>
                    <td>{{ $end->format('Y-m-d') }}</td>
                    <td>{{ $totalDays }} Hari</td>
                    <td>{{ $status }}</td>
                    <td>
                        @if($denda > 0)
                            Rp. {{ number_format($denda, 0, ',', '.') }} ({{ $lateDays }} Hari)
                        @else
                            Rp. 0
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="mt-2"><i>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</i></p>

</body>
</html>
