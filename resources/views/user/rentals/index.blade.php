@extends('user.layouts.app')

@section('title', 'Penyewaan Dunia Virtual')

@section('content')
<div class="container mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-white drop-shadow-lg">🌌 Sewa Dunia Virtual Anda</h1>
        <p class="text-gray-300 mt-2">Pilih dunia virtual favoritmu dan tentukan durasi penyewaan.</p>

        {{-- Live Search --}}
        <input type="text" id="searchInput" placeholder="Cari nama atau kode..."
            class="mt-4 w-1/2 p-2 rounded-md bg-gray-800 border border-gray-700 text-white focus:ring-2 focus:ring-cyan-500">
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="bg-green-500 text-white px-4 py-3 rounded-lg mb-6 text-center shadow-lg animate-pulse">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-500 text-white px-4 py-3 rounded-lg mb-6 text-center shadow-lg animate-bounce">
            {{ session('error') }}
        </div>
    @endif

    {{-- List Virtual Worlds --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($virtualWorlds as $world)
        <div class="bg-gray-900 rounded-2xl shadow-lg hover:shadow-cyan-500/30 transition duration-300 overflow-hidden rental-card relative"
             data-name="{{ strtolower($world->name) }}"
             data-code="{{ strtolower($world->code) }}"
             data-is-rented="{{ $world->is_rented }}"
             data-is-available="{{ $world->is_available ?? 1 }}">
            
            <div class="relative">
                <img src="{{ $world->image ? asset('storage/' . $world->image) : asset('images/default-world.jpg') }}" 
                     alt="{{ $world->name }}" class="w-full h-48 object-cover">
                <div class="absolute top-2 right-2 bg-cyan-600 text-white text-xs px-3 py-1 rounded-full shadow">
                    {{ $world->categories->pluck('name')->join(', ') ?: 'Tanpa Kategori' }}
                </div>
            </div>

            <div class="p-5 text-gray-300">
                <h3 class="text-xl font-semibold text-cyan-400">{{ $world->name }}</h3>
                <p class="text-sm mt-2 line-clamp-2">{{ $world->description ?? 'Tidak ada deskripsi.' }}</p>

                {{-- Form Sewa --}}
                <form action="{{ route('user.rentals.store') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="virtual_world_id" value="{{ $world->id }}">
                    <div class="flex flex-col gap-2">
                        <label for="start_date_{{ $world->id }}" class="text-sm text-gray-400">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date_{{ $world->id }}" 
                               class="rounded-lg bg-gray-800 border border-gray-700 text-white px-3 py-2 focus:ring-2 focus:ring-cyan-500" required>

                        <label for="end_date_{{ $world->id }}" class="text-sm text-gray-400">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date_{{ $world->id }}" 
                               class="rounded-lg bg-gray-800 border border-gray-700 text-gray-400 px-3 py-2 focus:ring-2 focus:ring-cyan-500" readonly>
                    </div>

                    <p class="text-xs text-cyan-400 mt-1 italic">
                        ⏱️ Masa sewa otomatis berakhir 5 hari setelah tanggal mulai. Denda akan berlaku jika terlambat mengembalikan.
                    </p>

                    <button type="submit"
                        class="w-full mt-4 bg-cyan-500 hover:bg-cyan-600 text-white font-semibold py-2 rounded-lg shadow-lg transition duration-200">
                        🚀 Sewa Sekarang
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Jika tidak ada data --}}
    @if($virtualWorlds->isEmpty())
        <div class="text-center text-gray-500 mt-10">
            <p>Tidak ada dunia virtual tersedia saat ini 🌍</p>
        </div>
    @endif
</div>

{{-- Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto end date +5 hari
    document.querySelectorAll('[id^="start_date_"]').forEach(input => {
        input.addEventListener('change', function() {
            const worldId = this.id.split('_')[2];
            const startDate = new Date(this.value);
            if (!isNaN(startDate)) {
                const endDate = new Date(startDate);
                endDate.setDate(endDate.getDate() + 5);
                const endInput = document.getElementById(`end_date_${worldId}`);
                endInput.value = endDate.toISOString().split('T')[0];
            }
        });
    });

    // Live search
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.rental-card');

    searchInput.addEventListener('input', function() {
        const keyword = this.value.toLowerCase();
        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const code = card.getAttribute('data-code');
            if (name.includes(keyword) || code.includes(keyword)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Overlay "Sedang disewa" & disable form
    cards.forEach(card => {
        const isRented = card.getAttribute('data-is-rented') === '1';
        const isAvailable = card.getAttribute('data-is-available') === '1';
        if (isRented && !isAvailable) {
            const overlay = document.createElement('div');
            overlay.className = 'absolute inset-0 bg-black/70 flex items-center justify-center text-white text-lg font-bold rounded-2xl';
            overlay.innerText = '🌌 Dunia ini sedang disewa';
            card.appendChild(overlay);

            const form = card.querySelector('form');
            if (form) form.style.display = 'none';
        }
    });
});
</script>
@endsection
