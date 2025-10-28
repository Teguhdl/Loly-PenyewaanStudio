<aside class="w-64 bg-[#0f1329]/80 backdrop-blur-md border-r border-cyan-700 h-screen p-6 fixed">
    <h2 class="text-xl font-bold text-cyan-300 mb-8 neon-text">VR World Admin</h2>
    <nav class="flex flex-col space-y-3">
        <a href="{{ route('admin.dashboard') }}" 
           class="hover:text-cyan-400 {{ request()->routeIs('admin.dashboard') ? 'text-cyan-300 font-semibold' : 'text-gray-400' }}">
           🧭 Dashboard
        </a>
        <a href="#" class="hover:text-cyan-400 text-gray-400">🎮 Virtual Worlds</a>
        <a href="#" class="hover:text-cyan-400 text-gray-400">🏠 Rentals</a>
        <a href="#" class="hover:text-cyan-400 text-gray-400">👤 Users</a>
    </nav>
</aside>
