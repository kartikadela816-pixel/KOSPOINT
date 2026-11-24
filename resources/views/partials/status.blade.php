{{-- Lencana status/role. Pemakaian: @include('partials.status', ['nilai' => $kos->status_kos]) --}}
@php
    $kelasStatus = match ($nilai) {
        'aktif', 'tersedia' => 'bg-brand-100 text-brand-800',
        'terisi' => 'bg-brand-700 text-white',
        'draft', 'dipesan' => 'bg-amber-100 text-amber-800',
        'nonaktif' => 'bg-slate-200 text-slate-600',
        'admin' => 'bg-slate-900 text-white',
        'pemilik' => 'bg-brand-200 text-brand-900',
        default => 'bg-surface text-slate-700',
    };
@endphp
<span class="inline-flex whitespace-nowrap rounded-full px-2.5 py-0.5 text-xs font-bold capitalize {{ $kelasStatus }}">{{ $nilai }}</span>
