<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KosPoint') - Temukan Kos Impianmu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: {
            brand: { 50:'#effcf5',100:'#d8f7e5',200:'#b5edce',300:'#83ddb0',400:'#4bc58a',500:'#22a568',600:'#168653',700:'#126b44',800:'#105539',900:'#0d452f' }
        }, boxShadow: { soft:'0 12px 35px rgba(15, 75, 49, .08)' } } } }
    </script>
    <style>
        html { scroll-behavior:smooth; }
        body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        .kp-pattern { background-image: radial-gradient(rgba(255,255,255,.17) 1px, transparent 1px); background-size: 18px 18px; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-[#f7faf8] text-slate-800 antialiased">
    <header class="sticky top-0 z-40 border-b border-emerald-100 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-3.5 lg:px-8">
            <a href="{{ route('beranda') }}" class="flex items-center gap-2.5">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-brand-600 text-white shadow-sm">
                    <svg viewBox="0 0 24 24" class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z"/><path d="M8 10h.01M16 10h.01"/></svg>
                </span>
                <span class="text-2xl font-extrabold tracking-tight text-brand-800">Kos<span class="text-brand-500">Point</span></span>
            </a>
            <nav class="hidden items-center gap-8 text-sm font-semibold text-slate-600 md:flex">
                <a href="{{ route('beranda') }}" class="transition hover:text-brand-600">Beranda</a>
                <a href="{{ route('kos.cari') }}" class="transition hover:text-brand-600">Cari Kos</a>
                <a href="{{ route('peta.index') }}" class="transition hover:text-brand-600">Peta</a>
                @auth @if(auth()->user()->role === 'pencari')<a href="{{ route('favorit.index') }}" class="transition hover:text-brand-600">Favorit</a>@endif @endauth
            </nav>
            <div class="flex items-center gap-2.5">
                @auth
                    <span class="hidden text-sm font-semibold text-slate-600 sm:inline">{{ auth()->user()->name }}</span>
                    @if(auth()->user()->role === 'pencari')
                        <a href="{{ route('favorit.index') }}" class="hidden rounded-xl px-3 py-2 text-sm font-semibold text-brand-700 hover:bg-brand-50 sm:inline-flex">Favorit</a>
                    @elseif(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="hidden rounded-xl px-3 py-2 text-sm font-semibold text-brand-700 hover:bg-brand-50 sm:inline-flex">Dashboard</a>
                    @elseif(auth()->user()->role === 'pemilik')
                        <a href="{{ route('pemilik.dashboard') }}" class="hidden rounded-xl px-3 py-2 text-sm font-semibold text-brand-700 hover:bg-brand-50 sm:inline-flex">Dashboard</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST">@csrf
                        <button class="rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl px-3.5 py-2.5 text-sm font-bold text-brand-700 transition hover:bg-brand-50">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="mx-auto mt-4 max-w-7xl px-5 lg:px-8"><div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div></div>
    @endif
    @if(session('error'))
        <div class="mx-auto mt-4 max-w-7xl px-5 lg:px-8"><div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-700">{{ session('error') }}</div></div>
    @endif

    <main>@yield('content')</main>

    <footer class="mt-20 bg-brand-900 text-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-5 px-5 py-10 md:flex-row md:items-center md:justify-between lg:px-8">
            <div><div class="text-2xl font-extrabold">KosPoint</div><p class="mt-1 max-w-md text-sm leading-6 text-emerald-100/75">Temukan tempat tinggal nyaman yang dekat dengan aktivitasmu.</p></div>
            <p class="text-sm text-emerald-100/70">© {{ date('Y') }} KosPoint. Temukan kos, temukan nyaman.</p>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
