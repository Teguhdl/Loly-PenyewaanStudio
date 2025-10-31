@extends('user.layouts.app')

@section('title', 'Riwayat Penyewaan')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-white mb-6">📜 Riwayat Penyewaan</h1>

    @if(session('success'))
    <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-6 text-center shadow-lg">
        {{ session('success') }}
    </div>
    @elseif(session('error'))
    <div class="bg-red-500 text-white px-4 py-3 rounded-lg mb-6 text-center shadow-lg">
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($rentals as $rental)
        <div class="bg-gray-900 rounded-2xl shadow-lg p-5 text-gray-300">
            <h3 class="text-xl font-semibold text-cyan-400">{{ $rental->virtualWorld->name }}</h3>
            <p class="text-sm mt-1">Kode: {{ $rental->virtualWorld->code }}</p>
            <p class="text-sm mt-1">Tanggal Mulai: {{ $rental->start_date }}</p>
            <p class="text-sm mt-1">Tanggal Selesai: {{ $rental->end_date }}</p>
            <p class="text-sm mt-1">Status:
                @if($rental->status == 'ongoing')
                <span class="text-yellow-400">Sedang disewa</span>
                @elseif($rental->status == 'completed')
                <span class="text-green-400">Selesai</span>
                @else
                <span class="text-red-400">{{ $rental->status }}</span>
                @endif
            </p>
            <p class="text-sm mt-1">Pengembalian:
                @if($rental->return_requested)
                <span class="text-cyan-400">Menunggu ACC Admin</span>
                @elseif($rental->is_returned == True)
                <span class="text-green-400">Sudah dikembalikan</span>
                @else
                <span class="text-gray-400">Belum diajukan</span>
                @endif
            </p>

            @if($rental->status == 'ongoing' && !$rental->return_requested)
            <button type="button"
                data-route="{{ route('user.rentals.requestReturn', ['id' => $rental->id]) }}"
                onclick="confirmReturnRequest(this)"
                class="w-full bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-2 rounded-lg shadow-lg">
                Ajukan Pengembalian
            </button>



            @endif
        </div>
        @empty
        <p class="text-gray-400 text-center col-span-full">Belum ada riwayat penyewaan.</p>
        @endforelse
    </div>
</div>
<script>
    function confirmReturnRequest(button) {
        const url = button.dataset.route;

        $.post(url, {
            _token: '{{ csrf_token() }}'
        }, function(response) {
            if (response.type === 'penalty_required') {
                Swal.fire({
                    title: 'Telat Pengembalian!',
                    html: `${response.message}<br><br>Lanjut ke pembayaran denda?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lanjut Bayar',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = response.payment_url;
                    }
                });
            } else if (response.type === 'return_requested') {
                Swal.fire('Berhasil!', response.message, 'success');
                location.reload();
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        }).fail(function(xhr) {
            Swal.fire('Error', xhr.responseJSON?.message ?? 'Terjadi kesalahan');
        });
    }
</script>
@endsection