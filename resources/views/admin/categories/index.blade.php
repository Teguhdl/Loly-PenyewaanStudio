@extends('admin.layouts.app')

@section('content')
<div class="glow-card p-8 rounded-2xl max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold neon-text text-cyan-300">Daftar Kategori Dunia Virtual</h2>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-cyan-500 hover:bg-cyan-400 rounded-lg text-white">
            Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-600 text-white rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full text-left border border-gray-700 rounded-md">
        <thead class="bg-[#1b1b3a] text-cyan-300">
            <tr>
                <th class="px-4 py-2 border-b border-gray-700">ID</th>
                <th class="px-4 py-2 border-b border-gray-700">Nama</th>
                <th class="px-4 py-2 border-b border-gray-700">Deskripsi</th>
                <th class="px-4 py-2 border-b border-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
                <tr class="hover:bg-[#2a2a50]">
                    <td class="px-4 py-2 border-b border-gray-700">{{ $cat->id }}</td>
                    <td class="px-4 py-2 border-b border-gray-700">{{ $cat->name }}</td>
                    <td class="px-4 py-2 border-b border-gray-700">{{ $cat->description ?? '-' }}</td>
                    <td class="px-4 py-2 border-b border-gray-700">
                        <a href="{{ route('admin.categories.edit', $cat->id) }}" class="px-2 py-1 bg-yellow-500 rounded hover:bg-yellow-400 text-white">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus kategori ini?')" class="px-2 py-1 bg-red-500 rounded hover:bg-red-400 text-white">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @if($categories->isEmpty())
                <tr>
                    <td colspan="4" class="px-4 py-2 text-center text-gray-400">Belum ada kategori.</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
