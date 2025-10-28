@extends('admin.layouts.app')

@section('content')
<div class="glow-card p-6 rounded-2xl">
    <h2 class="text-2xl neon-text text-cyan-300 mb-4 font-bold">Daftar User</h2>

    @if(session('success'))
        <div class="text-green-400 mb-4">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.users.create') }}" class="inline-block mb-4 px-4 py-2 bg-cyan-500 hover:bg-cyan-400 rounded-lg text-white">
        Tambah User Baru
    </a>

    <table class="w-full text-left text-white border border-cyan-600 rounded-lg">
        <thead class="bg-[#0f1329] border-b border-cyan-600">
            <tr>
                <th class="p-2">#</th>
                <th class="p-2">Nama</th>
                <th class="p-2">Email</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="border-b border-cyan-700">
                <td class="p-2">{{ $loop->iteration }}</td>
                <td class="p-2">{{ $user->name }}</td>
                <td class="p-2">{{ $user->email }}</td>
                <td class="p-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="px-3 py-1 bg-cyan-500 hover:bg-cyan-400 rounded-lg text-white">
                        Edit
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }} <!-- pagination -->
    </div>
</div>
@endsection
