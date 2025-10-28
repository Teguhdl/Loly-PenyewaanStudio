@extends('admin.layouts.app')

@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="glow-card p-6 rounded-2xl text-center">
        <h2 class="text-xl font-semibold text-cyan-300">Total Users</h2>
        <p class="text-4xl font-bold mt-3">{{ $summary['total_users'] }}</p>
    </div>

    <div class="glow-card p-6 rounded-2xl text-center">
        <h2 class="text-xl font-semibold text-cyan-300">Admins</h2>
        <p class="text-4xl font-bold mt-3">{{ $summary['total_admins'] }}</p>
    </div>

    <div class="glow-card p-6 rounded-2xl text-center">
        <h2 class="text-xl font-semibold text-cyan-300">Members</h2>
        <p class="text-4xl font-bold mt-3">{{ $summary['total_members'] }}</p>
    </div>
</div>
@endsection
