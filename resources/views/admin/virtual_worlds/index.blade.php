@extends('admin.layouts.app')

@section('title','Daftar Virtual World')

@section('content')
<div class="glow-card p-8 rounded-2xl max-w-8xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl text-cyan-400 font-bold">Daftar Dunia Virtual</h2>
        <a href="{{ route('admin.virtual_worlds.create') }}" class="bg-cyan-600 hover:bg-cyan-500 px-4 py-2 rounded neon-btn">Tambah Baru</a>
    </div>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-600 text-white rounded">{{ session('success') }}</div>
    @endif

    <table class="w-full text-left table-auto border-collapse border border-gray-700">
        <thead class="bg-gray-800 text-cyan-400">
            <tr>
                <th class="px-4 py-2 border border-gray-600">No</th>
                <th class="px-4 py-2 border border-gray-600">Kode</th>
                <th class="px-4 py-2 border border-gray-600">Nama</th>
                <th class="px-4 py-2 border border-gray-600">Kategori</th>
                <th class="px-4 py-2 border border-gray-600">Status</th>
                <th class="px-4 py-2 border border-gray-600">Harga Denda/ Hari</th>
                <th class="px-4 py-2 border border-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($virtualWorlds as $vw)
            <tr class="bg-gray-900 hover:bg-gray-800">
                <td class="px-4 py-2 border border-gray-700">{{ $loop->iteration }}</td>
                <td class="px-4 py-2 border border-gray-700">{{ $vw->code }}</td>
                <td class="px-4 py-2 border border-gray-700">{{ $vw->name }}</td>
                <td class="px-4 py-2 border border-gray-700">
                    @foreach($vw->categories as $cat)
                    <span class="bg-cyan-700 px-2 py-1 rounded text-sm">{{ $cat->name }}</span>
                    @endforeach
                </td>
                <td class="px-4 py-2 border border-gray-700">{{ $vw->is_rented ? 'Disewa' : 'Tersedia' }}</td>
                <td class="px-4 py-2 border border-gray-700">Rp. {{ number_format($vw->price_per_day,0,',','.') }}</td>
                <td class="px-4 py-2 border border-gray-700 flex gap-2">
                    <a href="{{ route('admin.virtual_worlds.edit', $vw->id) }}" class="bg-blue-600 px-2 py-1 rounded neon-btn">Edit</a>
                    <form action="{{ route('admin.virtual_worlds.destroy', $vw->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 px-2 py-1 rounded neon-btn">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @if($virtualWorlds->isEmpty())
            <tr>
                <td colspan="6" class="px-4 py-2 text-center text-gray-400">Belum ada dunia virtual.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

@endsection