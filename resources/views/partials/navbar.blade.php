<header class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">
        @include('partials.logo', ['denganSlogan' => true])

        <button type="button" id="tombol-menu" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-700 md:hidden" aria-label="Buka menu" aria-expanded="false" aria-controls="menu-mobile">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5" aria-hidden="true">
                <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
            </svg>
        </button>

        <nav class="hidden items-center gap-6 text-sm font-semibold text-slate-600 md:flex" aria-label="Menu utama">
            @include('partials.menu-tautan')
        </nav>
    </div>

    <nav id="menu-mobile" class="hidden border-t border-slate-200/70 bg-white px-4 py-3 md:hidden" aria-label="Menu mobile">
        <div class="flex flex-col gap-1 text-sm font-semibold text-slate-700">
            @include('partials.menu-tautan', ['mobile' => true])
        </div>
    </nav>
</header>
