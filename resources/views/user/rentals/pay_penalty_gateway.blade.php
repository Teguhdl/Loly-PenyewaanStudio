@extends('user.layouts.app')

@section('title', 'Proses Pembayaran Denda')

@section('content')
<div class="container mx-auto px-4 py-8 text-center">
    <h1 class="text-3xl font-bold text-white mb-6">💳 Sedang Memproses Pembayaran ...</h1>

    <div class="bg-gray-900 rounded-2xl shadow-lg p-6 text-gray-300 max-w-lg mx-auto">
        <p class="mb-4">Denda sebesar 
            <span class="text-red-400 font-bold">Rp{{ number_format($amount, 0, ',', '.') }}</span>
        </p>
        <p>Untuk keterlambatan selama 
            <span class="text-yellow-400 font-bold">{{ $lateDays }} hari</span>
        </p>
        <p class="text-sm text-gray-400 mt-3">
            Popup pembayaran akan muncul otomatis. Jangan tutup halaman ini.
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // gunakan snapToken yang sudah disimpan di payment model
    window.snap.pay('{{ $payment->snap_token }}', {
        onSuccess: function (result) {
            fetch('{{ route('user.rentals.midtransCallback') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify(result)
            })
            .then(res => res.json())
            .then((resJson) => {
                if (resJson.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran Berhasil!',
                        text: 'Denda telah dibayar dan pengajuan pengembalian otomatis dikirim.',
                        confirmButtonColor: '#06b6d4'
                    }).then(() => {
                        window.location.href = '{{ route('user.rentals.history') }}';
                    });
                } else {
                    Swal.fire('Info', resJson.message ?? 'Pembayaran diproses, cek riwayat.', 'info').then(() => {
                        window.location.href = '{{ route('user.rentals.history') }}';
                    });
                }
            }).catch((e) => {
                Swal.fire('Error', 'Gagal memproses callback: ' + (e.message || ''), 'error');
            });
        },
        onPending: function (result) {
            Swal.fire({
                icon: 'info',
                title: 'Menunggu Pembayaran',
                text: 'Silakan selesaikan pembayaran Anda terlebih dahulu.',
                confirmButtonColor: '#06b6d4'
            });
        },
        onError: function (result) {
            Swal.fire({
                icon: 'error',
                title: 'Pembayaran Gagal',
                text: 'Terjadi kesalahan saat memproses pembayaran.',
                confirmButtonColor: '#06b6d4'
            });
        },
        onClose: function () {
            Swal.fire({
                icon: 'warning',
                title: 'Popup Ditutup',
                text: 'Kamu menutup popup pembayaran sebelum selesai.',
                confirmButtonColor: '#06b6d4'
            });
        }
    });
});
</script>
@endsection
