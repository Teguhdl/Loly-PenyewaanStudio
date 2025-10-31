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

    <div class="glow-card p-8 rounded-2xl max-w-8xl mx-auto mb-6">
        <div class="flex items-center gap-4">
            <label class="text-gray-300 font-semibold">Filter per User:</label>
            <select id="filter-user" class="px-3 py-2 rounded bg-gray-800 border border-gray-700 text-white">
                <option value="">Semua User</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>

            {{-- Tombol Cetak --}}
            <a id="print-btn"
                href="{{ route('admin.rental.print') }}"
                target="_blank"
                class="bg-green-600 hover:bg-green-500 px-4 py-2 rounded text-white">
                🖨️ Cetak Laporan
            </a>
        </div>
    </div>



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
                <th class="px-4 py-2 border border-gray-600">Pembayaran</th>
                <th class="px-4 py-2 border border-gray-600">Pengembalian</th>



            </tr>
        </thead>
        <tbody id="rental-table-body">
            <tr>
                <td colspan="10" class="text-center text-gray-400 py-4">Memuat data...</td>
            </tr>
        </tbody>

    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterUser = document.getElementById('filter-user');
        const tbody = document.getElementById('rental-table-body');

        // Fungsi ambil data rental
        function loadRentals(userId = '') {
            tbody.innerHTML = `<tr><td colspan="10" class="text-center text-gray-400 py-4">Memuat data...</td></tr>`;

            fetch(`{{ route('admin.rental.data') }}?user_id=${userId}`)
                .then(res => res.json())
                .then(res => {
                    tbody.innerHTML = '';
                    const data = res.data;

                    if (data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="10" class="text-center text-gray-400 py-4">Belum ada data rental.</td></tr>`;
                        return;
                    }

                    data.forEach((rental, i) => {
                        let dendaText = rental.denda > 0 ?
                            `Rp ${rental.denda.toLocaleString('id-ID')} (${rental.lateDays} Hari)` :
                            'Rp 0';

                        let pembayaranText = '-';
                        if (rental.payment) {
                            pembayaranText = `
            <div>
                <span class="text-sm text-gray-300">Status: ${rental.payment.status}</span><br>
                <a href="/admin/payments/${rental.payment.id}" 
                   class="text-cyan-400 underline hover:text-cyan-300">
                    Detail Pembayaran
                </a>
            </div>
        `;
                        } else if (rental.denda > 0) {
                            pembayaranText = `<span class="text-yellow-400">Belum Dibayar</span>`;
                        }

                        let pengembalian = '';
                        if (rental.return_requested && rental.rental_status === 'ongoing') {
                            pengembalian = `
            <form action="rentals/approve-return/${rental.id}" method="POST">
                @csrf
                <button type="submit" class="bg-green-600 px-2 py-1 rounded hover:bg-green-500 text-white">
                    ACC Pengembalian
                </button>
            </form>`;
                        } else if (rental.rental_status === 'returned') {
                            pengembalian = `<span class="text-cyan-400">Sudah Dikembalikan</span>`;
                        } else if (rental.rental_status === 'overdue') {
                            pengembalian = `<span class="text-cyan-400">Bayar Pinalti Denda</span>`;
                        } else {
                            pengembalian = `<span class="text-gray-400">Belum Ada Pengajuan</span>`;
                        }

                        tbody.insertAdjacentHTML('beforeend', `
        <tr class="bg-gray-900 hover:bg-gray-800 text-gray-300">
            <td class="px-4 py-2 border border-gray-700">${i + 1}</td>
            <td class="px-4 py-2 border border-gray-700">${rental.user}</td>
            <td class="px-4 py-2 border border-gray-700">${rental.virtualWorld}</td>
            <td class="px-4 py-2 border border-gray-700">${rental.code}</td>
            <td class="px-4 py-2 border border-gray-700">${rental.start}</td>
            <td class="px-4 py-2 border border-gray-700">${rental.end}</td>
            <td class="px-4 py-2 border border-gray-700">${rental.totalDays} Hari</td>
            <td class="px-4 py-2 border border-gray-700">${rental.status}</td>
            <td class="px-4 py-2 border border-gray-700">${dendaText}</td>
            <td class="px-4 py-2 border border-gray-700">${pembayaranText}</td>
            <td class="px-4 py-2 border border-gray-700">${pengembalian}</td>
        </tr>
    `);
                    });

                })
                .catch(err => {
                    tbody.innerHTML = `<tr><td colspan="10" class="text-center text-red-400 py-4">Gagal memuat data.</td></tr>`;
                    console.error(err);
                });
        }

        // Load awal
        loadRentals();

        // Event filter user
        filterUser.addEventListener('change', function() {
            loadRentals(this.value);
            const printBtn = document.getElementById('print-btn');
            printBtn.href = `{{ route('admin.rental.print') }}?user_id=${this.value}`;
        });
    });
</script>

@endsection