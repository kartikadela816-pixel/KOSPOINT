@php
    $pengguna = auth()->user();
    $adalahAdmin = $pengguna->role === 'admin';
    $namaPeran = match ($pengguna->role) {
        'pemilik' => 'Pemilik Kos',
        'admin' => 'Admin',
        default => 'Pencari Kos',
    };
    $huruf = mb_strtoupper(mb_substr($pengguna->name, 0, 1));

    // Setiap menu: [label, nama route, pola route aktif, ikon]
    $ikonRingkasan = 'M4 4h6v6H4zM14 4h6v6h-6zM4 14h6v6H4zM14 14h6v6h-6z';
    $ikonKos = 'M3 21h18M6 21V10l6-5 6 5v11M10 21v-5h4v5';
    $ikonPengguna = 'M9 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM3 19a6 6 0 0 1 12 0M16 11a3 3 0 1 0 0-6M17 14a5 5 0 0 1 4 5';
    $ikonProfil = 'M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM4 20a8 8 0 0 1 16 0';

    $menu = $adalahAdmin
        ? [
            ['Ringkasan', 'admin.dashboard', ['admin.dashboard'], $ikonRingkasan],
            ['Pengguna', 'admin.pengguna.index', ['admin.pengguna.*'], $ikonPengguna],
            ['Kos & Kamar', 'admin.kos.index', ['admin.kos.*', 'admin.kamar.*'], $ikonKos],
            ['Profil', 'profil.edit', ['profil.*'], $ikonProfil],
        ]
        : [
            ['Ringkasan', 'pemilik.dashboard', ['pemilik.dashboard'], $ikonRingkasan],
            ['Kos Saya', 'pemilik.kos.index', ['pemilik.kos.*', 'pemilik.kamar.*'], $ikonKos],
            ['Profil', 'profil.edit', ['profil.*'], $ikonProfil],
        ];
@endphp

<div class="flex h-full flex-col justify-between gap-6">
    <div>
        <div class="hidden lg:block">
            @include('partials.logo', ['lencana' => $adalahAdmin ? 'Admin' : 'Mitra'])
        </div>

        <div class="flex flex-col gap-1 text-sm font-semibold lg:mt-8">
            @foreach ($menu as [$label, $rute, $pola, $ikon])
                @php $aktif = request()->routeIs(...$pola); @endphp
                <a href="{{ route($rute) }}"
                   class="flex items-center gap-3 rounded-xl px-3 py-2.5 {{ $aktif ? 'bg-brand-200 text-brand-900' : 'text-slate-600 hover:bg-brand-50' }}"
                   @if ($aktif) aria-current="page" @endif>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 shrink-0" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $ikon }}" />
                    </svg>
                    {{ $label }}
                </a>
            @endforeach
            <a href="{{ route('beranda') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-slate-600 hover:bg-brand-50">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 shrink-0" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 11l9-7 9 7M5 10v10h14V10" />
                </svg>
                Lihat Beranda
            </a>
        </div>
    </div>

    <div class="flex items-center gap-3 rounded-2xl bg-surface p-3">
        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-700 text-sm font-bold text-white" aria-hidden="true">{{ $huruf }}</span>
        <div class="min-w-0 flex-1 leading-tight">
            <p class="truncate text-sm font-bold text-slate-900">{{ $pengguna->name }}</p>
            <p class="truncate text-xs text-slate-500">{{ $namaPeran }}</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-500 hover:bg-red-50 hover:text-red-600" aria-label="Logout" title="Logout">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 4H5v16h4M16 8l4 4-4 4M20 12H9" />
                </svg>
            </button>
        </form>
    </div>
</div>
