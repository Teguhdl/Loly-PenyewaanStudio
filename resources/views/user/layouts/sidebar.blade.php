<nav class="flex justify-between items-center px-8 py-4 border-b border-cyan-700 bg-[#0f1329]/80 backdrop-blur-md sticky top-0 z-50">
    <div class="text-2xl font-bold neon-text">🌐 VR World</div>

    <div class="flex items-center space-x-6">
        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
        <a href="{{ route('user.rentals.index') }}" class="nav-link {{ request()->routeIs('user.rentals.index') ? 'active' : '' }}">🎮 Sewa Dunia</a>
        <a href="{{ route('user.rentals.history') }}" class="nav-link {{ request()->routeIs('user.history.history') ? 'active' : '' }}">📜 Riwayat</a>
        <a href="{{ route('user.profile.edit') }}" class="nav-link {{ request()->routeIs('user.profile.edit') ? 'active' : '' }}">👤 Profil</a>
    </div>

    <div class="flex items-center space-x-3 text-sm">
        <span class="text-cyan-300">Halo, {{ auth()->user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-cyan-700 hover:bg-cyan-600 text-white px-3 py-1 rounded-md text-xs">
                Logout
            </button>
        </form>
    </div>
</nav>
