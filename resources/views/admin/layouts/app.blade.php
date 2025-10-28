@include('admin.layouts.head')

<body class="flex">
    @include('admin.layouts.sidebar')

    <div class="flex-1 ml-64 flex flex-col min-h-screen">
        <header class="p-4 border-b border-cyan-700 flex justify-between items-center">
            <h1 class="text-2xl font-semibold neon-text">{{ $pageTitle ?? 'Dashboard' }}</h1>
            <span class="text-sm text-cyan-300">Halo, {{ auth()->user()->name }}</span>
        </header>

        <main class="flex-1 p-8">
            @yield('content')
        </main>

        @include('admin.layouts.footer')
    </div>
</body>
