<a href="{{ route('beranda') }}" class="inline-flex items-center gap-2.5 {{ $class ?? '' }}">
    @include('partials.logo-mark')
    <span class="leading-none">
        <span class="flex items-center gap-1.5">
            <span class="text-base font-extrabold tracking-tight text-brand-900">KOSPOINT</span>
            @if (!empty($lencana))
                <span class="rounded-full bg-brand-200 px-2 py-0.5 text-[10px] font-bold text-brand-900">{{ $lencana }}</span>
            @endif
        </span>
        @if (!empty($denganSlogan))
            <span class="mt-1 block text-[11px] font-medium text-slate-500">Sewa kos tanpa ribet</span>
        @endif
    </span>
</a>
