@extends('admin.layouts.app')

@section('content')
<div class="glow-card p-8 rounded-2xl max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold neon-text text-cyan-300 mb-6">Tambah Kategori Dunia Virtual</h2>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-[#2a2a50] border border-red-500 text-red-400 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-300 mb-1">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full p-2 rounded-md bg-[#0f1329]/50 border border-cyan-600 text-white">
        </div>

        <div class="mb-4">
            <label class="block text-gray-300 mb-1">Deskripsi</label>
            <textarea name="description" class="w-full p-2 rounded-md bg-[#0f1329]/50 border border-cyan-600 text-white" rows="3">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="px-6 py-2 bg-cyan-500 hover:bg-cyan-400 rounded-lg text-white">
            Tambah Kategori
        </button>
    </form>
</div>
@endsection
