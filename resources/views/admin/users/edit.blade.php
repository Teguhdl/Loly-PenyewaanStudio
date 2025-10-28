@extends('admin.layouts.app')

@section('content')
<div class="glow-card p-8 rounded-2xl max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold neon-text text-cyan-300 mb-6">Edit User</h2>

    <!-- Error List -->
    @if ($errors->any())
        <div class="mb-4 p-3 bg-[#2a2a50] border border-red-500 text-red-400 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-600 text-white rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-300 mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                   class="w-full p-2 rounded-md bg-[#0f1329]/50 border border-cyan-600 text-white">
        </div>

        <div class="mb-4">
            <label class="block text-gray-300 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                   class="w-full p-2 rounded-md bg-[#0f1329]/50 border border-cyan-600 text-white">
        </div>

        <div class="mb-4">
            <label class="block text-gray-300 mb-1">Password Baru (opsional)</label>
            <input type="password" name="password" class="w-full p-2 rounded-md bg-[#0f1329]/50 border border-cyan-600 text-white">
        </div>

        <div class="mb-4">
            <label class="block text-gray-300 mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full p-2 rounded-md bg-[#0f1329]/50 border border-cyan-600 text-white">
        </div>

        <button type="submit" class="px-6 py-2 bg-cyan-500 hover:bg-cyan-400 rounded-lg text-white">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
