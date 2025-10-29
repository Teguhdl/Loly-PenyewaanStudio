@include('user.layouts.head')

<body class="flex flex-col min-h-screen">
    @include('user.layouts.sidebar')

    <main class="flex-1 p-8">
        @yield('content')
    </main>

    @include('user.layouts.footer')
</body>
