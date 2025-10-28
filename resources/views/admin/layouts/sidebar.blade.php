<aside class="w-64 bg-[#0f1329]/80 backdrop-blur-md border-r border-cyan-700 h-screen p-6 fixed">
    <h2 class="text-xl font-bold text-cyan-300 mb-8 neon-text">VR World Admin</h2>
    <nav class="flex flex-col space-y-3">
        <a href="{{ route('admin.dashboard') }}"
            class="hover:text-cyan-400 {{ request()->routeIs('admin.dashboard') ? 'text-cyan-300 font-semibold' : 'text-gray-400' }}">
            🧭 Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}" class="hover:text-cyan-400 {{ request()->routeIs('admin.users.index') ? 'text-cyan-300 font-semibold' : 'text-gray-400' }}">👤 Users</a>
        <a href="{{ route('admin.categories.index') }}" class="hover:text-cyan-400 {{ request()->routeIs('admin.categories.index') ? 'text-cyan-300 font-semibold' : 'text-gray-400' }}">
            🎮 Kategori Virtual Worlds
        </a>
        <a href="{{ route('admin.virtual_worlds.index') }}" class="hover:text-cyan-400 {{ request()->routeIs('admin.virtual_worlds.index') ? 'text-cyan-300 font-semibold' : 'text-gray-400' }}">
            🎮 Virtual Worlds
        </a>
        <a href="#" class="hover:text-cyan-400 text-gray-400">🏠 Rentals</a>
    </nav>
</aside>