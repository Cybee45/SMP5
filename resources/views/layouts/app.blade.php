<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description" content="SMP Negeri 5 Sangatta Utara - Sekolah Menengah Pertama berkualitas di Kalimantan Timur dengan akreditasi B. Menciptakan generasi unggul, berkarakter, dan berprestasi.">
    <meta name="keywords" content="SMP Negeri 5 Sangatta Utara, sekolah menengah pertama, pendidikan berkualitas, Kalimantan Timur, akreditasi B">
    <meta name="author" content="SMP Negeri 5 Sangatta Utara">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $title ?? 'SMP Negeri 5 Sangatta Utara' }}">
    <meta property="og:description" content="Sekolah Menengah Pertama berkualitas dengan akreditasi B di Sangatta Utara, Kalimantan Timur.">
    <meta property="og:image" content="{{ asset('assets/logo/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Title -->
    <title>{{ $title ?? 'SMP Negeri 5 Sangatta Utara' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Performance CSS -->
    <link rel="stylesheet" href="{{ asset('css/performance.css') }}">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased overflow-x-hidden">
    <div class="min-h-screen bg-gray-100">
        @include('components.navbar.navbar')

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @include('components.footer.footer')
    </div>

    <!-- AOS Script -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    
    <!-- Performance Script -->
    <script src="{{ asset('js/performance.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                once: false,
                duration: 900,
                offset: 40,
                mirror: false
            });
        });
    </script>
</body>
</html>
