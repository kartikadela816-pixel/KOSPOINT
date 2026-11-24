@props(['judul', 'sub' => null, 'kembali' => null, 'teksKembali' => 'Kembali'])

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div class="min-w-0">
        @if ($kembali)
            <a href="{{ $kembali }}" class="mb-2 inline-flex items-center gap-1 text-sm font-semibold text-brand-700 hover:text-brand-800">
                <span aria-hidden="true">&lsaquo;</span> {{ $teksKembali }}
            </a>
        @endif
        <h1 class="break-words text-2xl font-extrabold tracking-tight text-slate-900 md:text-3xl">{{ $judul }}</h1>
        @if ($sub)
            <p class="mt-1 text-slate-600">{{ $sub }}</p>
        @endif
    </div>
    @if (! $slot->isEmpty())
        <div class="flex flex-wrap gap-2">{{ $slot }}</div>
    @endif
</div>
