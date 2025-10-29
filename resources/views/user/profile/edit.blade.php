@extends('user.layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10">
    <div class="glow-card rounded-2xl p-8 shadow-lg border border-cyan-600">
        <h2 class="text-3xl font-bold text-cyan-300 neon-text mb-6 text-center">
            ✨ Edit Profil Saya
        </h2>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-900/50 text-green-300 border border-green-600 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-900/40 border border-red-600 text-red-300 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="mb-5">
                <label class="block text-cyan-200 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full p-3 bg-[#0f1329]/70 border border-cyan-700 rounded-md text-white focus:ring-2 focus:ring-cyan-500 focus:outline-none">
            </div>

            {{-- Email --}}
            <div class="mb-5">
                <label class="block text-cyan-200 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" readonly
                       class="w-full p-3 bg-[#0f1329]/50 border border-cyan-800 rounded-md text-gray-400 cursor-not-allowed">
            </div>

            {{-- Nomor Telepon --}}
            <div class="mb-5">
                <label class="block text-cyan-200 mb-2">Nomor Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $profile->phone ?? '') }}"
                       class="w-full p-3 bg-[#0f1329]/70 border border-cyan-700 rounded-md text-white focus:ring-2 focus:ring-cyan-500 focus:outline-none">
            </div>

            {{-- Alamat --}}
            <div class="mb-5">
                <label class="block text-cyan-200 mb-2">Alamat</label>
                <textarea name="address" rows="3"
                          class="w-full p-3 bg-[#0f1329]/70 border border-cyan-700 rounded-md text-white focus:ring-2 focus:ring-cyan-500 focus:outline-none">{{ old('address', $profile->address ?? '') }}</textarea>
            </div>

            {{-- Avatar --}}
            <div class="mb-5">
                <label class="block text-cyan-200 mb-2">Foto Profil</label>
                <div class="flex items-center gap-6">
                    <div class="relative w-24 h-24">
                        <img id="avatarPreview"
                             src="{{ asset('storage/avatars/' . $profile->avatar) }}"
                             alt="Avatar Preview"
                             class="rounded-full w-24 h-24 object-cover border border-cyan-600 shadow-lg">
                    </div>
                    <input type="file" name="avatar" accept="image/*"
                           onchange="previewAvatar(event)"
                           class="text-sm text-cyan-200 file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-cyan-600 file:text-white
                                  hover:file:bg-cyan-500">
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="text-center mt-8">
                <button type="submit"
                        class="px-8 py-3 bg-cyan-500 hover:bg-cyan-400 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewAvatar(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('avatarPreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
