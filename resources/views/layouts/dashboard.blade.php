
<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-halaman font-sans text-slate-800 antialiased">

    <div class="min-h-screen lg:flex">

        {{-- SIDEBAR DESKTOP --}}
        <aside class="hidden w-64 shrink-0 border-r border-slate-200 bg-white p-5 lg:fixed lg:inset-y-0 lg:flex lg:flex-col">
            @include('partials.menu-dasbor')
        </aside>

        {{-- KONTEN UTAMA --}}
        <div class="min-w-0 flex-1 lg:ml-64">

            {{-- HEADER MOBILE --}}
            <header class="sticky top-0 z-30 flex items-center justify-between border-b border-slate-200 bg-white px-4 py-3 lg:hidden">
                <div>
                    @include('partials.logo')
                </div>
                <span class="text-sm font-semibold text-slate-600">
                    {{ auth()->user()->name }}
                </span>
            </header>

            {{-- MENU MOBILE --}}
            <nav class="flex gap-2 overflow-x-auto border-b border-slate-200 bg-white px-4 py-3 lg:hidden">
                @php
                    $adalahAdmin = auth()->user()->role === 'admin';
                @endphp

                <a href="{{ $adalahAdmin ? route('admin.dashboard') : route('pemilik.dashboard') }}"
                   class="shrink-0 rounded-lg bg-brand-100 px-3 py-2 text-sm font-semibold text-brand-800">
                    Ringkasan
                </a>

                @if ($adalahAdmin)
                    <a href="{{ route('admin.pengguna.index') }}"
                       class="shrink-0 rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-brand-50">
                        Pengguna
                    </a>
                    <a href="{{ route('admin.kos.index') }}"
                       class="shrink-0 rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-brand-50">
                        Kos & Kamar
                    </a>
                @else
                    <a href="{{ route('pemilik.kos.index') }}"
                       class="shrink-0 rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-brand-50">
                        Kos Saya
                    </a>
                @endif

                <a href="{{ route('profil.edit') }}"
                   class="shrink-0 rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-brand-50">
                    Profil
                </a>

                <a href="{{ route('beranda') }}"
                   class="shrink-0 rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-brand-50">
                    Beranda
                </a>

                <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                    @csrf
                    <button type="submit"
                            class="rounded-lg px-3 py-2 text-sm font-semibold text-red-600 hover:bg-red-50">
                        Keluar
                    </button>
                </form>
            </nav>

            {{-- ISI HALAMAN --}}
            <main class="mx-auto w-full max-w-7xl p-4 md:p-6 lg:p-8">
                @include('partials.flash')
                @yield('content')
            </main>

        </div>
    </div>

    <script src="{{ asset('js/kospoint.js') }}"></script>
</body>
</html>
