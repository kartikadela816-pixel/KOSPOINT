<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-halaman font-sans text-slate-800 antialiased">

    {{-- Halaman masuk dan daftar memakai tampilan polos, tanpa menu atas. --}}
    @unless (View::hasSection('polos'))
        @include('partials.navbar')
    @endunless

    <main>
        @yield('content')
    </main>

    @unless (View::hasSection('polos'))
        @include('partials.footer')
    @endunless

    <script src="{{ asset('js/kospoint.js') }}"></script>
</body>
</html>
