@extends('admin.layouts.app')

@section('content')
<div class="glow-card p-8 rounded-2xl max-w-2xl mx-auto bg-[#1b1b2e]/80 border border-cyan-600">
    <h2 class="text-2xl font-bold neon-text text-cyan-300 mb-6">Tambah Dunia Virtual</h2>

    {{-- Error --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-[#2a2a50] border border-red-500 text-red-400 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.virtual_worlds.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nama --}}
        <div class="mb-4">
            <label class="block text-gray-300 mb-1">Nama Dunia Virtual</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="w-full p-2 rounded-md bg-[#0f1329]/50 border border-cyan-600 text-white focus:ring-2 focus:ring-cyan-500">
        </div>

        {{-- Kode --}}
        <div class="mb-4">
            <label class="block text-gray-300 mb-1">Kode (Auto)</label>
            <input type="text" name="code" value="{{ old('code', $code ?? '') }}" readonly
                class="w-full p-2 rounded-md bg-[#0f1329]/50 border border-cyan-600 text-white">
        </div>

        {{-- Deskripsi --}}
        <div class="mb-4">
            <label class="block text-gray-300 mb-1">Deskripsi</label>
            <textarea name="description" rows="3"
                class="w-full p-2 rounded-md bg-[#0f1329]/50 border border-cyan-600 text-white focus:ring-2 focus:ring-cyan-500">{{ old('description') }}</textarea>
        </div>

        {{-- Harga Denda / Hari --}}
        <div class="mb-4">
            <label class="block text-gray-300 mb-1">Harga denda per Hari (jika lewat dari max hari rental)</label>
            <input type="number" name="price_per_day" value="{{ old('price_per_day') }}" required
                class="w-full p-2 rounded-md bg-[#0f1329]/50 border border-cyan-600 text-white focus:ring-2 focus:ring-cyan-500">
        </div>

        {{-- Kategori --}}
        <div class="mb-4">
            <label class="block text-gray-300 mb-1">Kategori (tahan Ctrl/Cmd untuk memilih beberapa)</label>
            <select name="categories[]" multiple
                class="w-full p-2 rounded-md bg-[#0f1329]/50 border border-cyan-600 text-white h-32 focus:ring-2 focus:ring-cyan-500">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Upload Gambar --}}
        <div class="mb-4">
            <label class="block text-gray-300 mb-1">Gambar Dunia Virtual</label>
            <input type="file" name="image" accept="image/*"
                class="w-full p-2 rounded-md bg-[#0f1329]/50 border border-cyan-600 text-white focus:ring-2 focus:ring-cyan-500">
        </div>

        {{-- Submit --}}
        <button type="submit" class="px-6 py-2 bg-cyan-500 hover:bg-cyan-400 rounded-lg text-white neon-btn shadow-lg">
            Tambah Dunia Virtual
        </button>
    </form>
</div>
@endsection
