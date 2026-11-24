@extends('layouts.dashboard')

@section('title', 'Dashboard Pemilik — KOSPOINT')

@section('content')
@php
    $warna = [
        'tersedia' => 'bg-brand-100 text-brand-900',
        'terisi' => 'bg-brand-700 text-white',
        'dipesan' => 'bg-amber-100 text-amber-900',
        'nonaktif' => 'bg-slate-200 text-slate-600',
    ];
@endphp

<section class="kp-kartu flex flex-col gap-4 p-5 md:flex-row md:items-center md:justify-between md:p-6">
    <div>
        <p class="kp-lencana">Portal pemilik</p>
        <h1 class="mt-3 text-2xl font-extrabold tracking-tight text-slate-900 md:text-3xl">Selamat datang, {{ auth()->user()->name }}</h1>
        <p class="mt-1 text-slate-600">Pantau kos dan ketersediaan kamar Anda.</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('pemilik.kos.create') }}" class="kp-tombol">+ Tambah Kos</a>
        <a href="{{ route('pemilik.kos.index') }}" class="kp-tombol-sekunder">Kelola Kos</a>
    </div>
</section>

{{-- Statistik --}}
<div class="mt-4 grid grid-cols-2 gap-4 lg:grid-cols-4">
    <div class="kp-kartu border-t-4 border-t-brand-700 p-4">
        <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Tingkat okupansi</p>
        <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ $okupansi }}%</p>
        <div class="mt-2 h-2 overflow-hidden rounded-full bg-surface" role="progressbar" aria-valuenow="{{ $okupansi }}" aria-valuemin="0" aria-valuemax="100">
            <div class="h-full rounded-full bg-brand-700" style="width: {{ $okupansi }}%"></div>
        </div>
    </div>
    <div class="kp-kartu border-t-4 border-t-brand-600 p-4">
        <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Kamar siap huni</p>
        <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ $perStatus['tersedia'] ?? 0 }} <span class="text-base font-bold">kamar</span></p>
        <p class="mt-1 text-xs text-brand-700">Potensi Rp {{ number_format($potensi, 0, ',', '.') }} / bulan</p>
    </div>
    <div class="kp-kartu border-t-4 border-t-amber-500 p-4">
        <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Kamar dipesan</p>
        <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ $perStatus['dipesan'] ?? 0 }} <span class="text-base font-bold">kamar</span></p>
        <p class="mt-1 text-xs text-amber-700">Perlu konfirmasi pemilik</p>
    </div>
    <div class="kp-kartu border-t-4 border-t-brand-200 p-4">
        <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Estimasi omzet</p>
        <p class="mt-1 text-2xl font-extrabold text-slate-900">Rp {{ number_format($omzet, 0, ',', '.') }}</p>
        <p class="mt-1 text-xs text-slate-500">{{ $totalKos }} kos ({{ $kosAktif }} aktif) · {{ $totalKamar }} kamar</p>
    </div>
</div>

<div class="mt-4 grid gap-4 lg:grid-cols-5">
    {{-- Denah status kamar --}}
    <section class="kp-kartu p-5 lg:col-span-3">
        <h2 class="font-bold text-slate-900">Status Kamar</h2>
        <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-600">
            @foreach (['tersedia' => 'Tersedia', 'terisi' => 'Terisi', 'dipesan' => 'Dipesan', 'nonaktif' => 'Nonaktif'] as $k => $t)
                <span class="inline-flex items-center gap-1.5"><span class="h-3 w-3 rounded {{ explode(' ', $warna[$k])[0] }} ring-1 ring-slate-200"></span>{{ $t }}</span>
            @endforeach
        </div>

        @if ($denah->isEmpty())
            <p class="mt-6 rounded-xl bg-surface px-4 py-8 text-center text-sm text-slate-600">Belum ada kamar. Tambahkan kamar dari halaman detail kos.</p>
        @else
            <div class="mt-4 grid grid-cols-2 gap-2 sm:grid-cols-3">
                @foreach ($denah as $kamar)
                    <a href="{{ route('pemilik.kamar.edit', $kamar->id) }}" class="rounded-xl p-3 transition hover:opacity-90 {{ $warna[$kamar->status_kamar] }}">
                        <p class="text-lg font-extrabold">{{ $kamar->nomor_kamar }}</p>
                        <p class="truncate text-xs font-semibold opacity-80">{{ $kamar->kos->nama_kos }}</p>
                        <p class="mt-1 text-xs capitalize opacity-90">{{ $kamar->status_kamar }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    {{-- Kos terbaru --}}
    <section class="kp-kartu p-5 lg:col-span-2">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-slate-900">Kos Saya</h2>
            <a href="{{ route('pemilik.kos.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-800">Lihat semua</a>
        </div>

        @forelse ($kosTerbaru as $kos)
            <a href="{{ route('pemilik.kos.show', $kos->id) }}" class="mt-3 block rounded-xl bg-surface p-3 transition hover:bg-brand-100">
                <div class="flex items-start justify-between gap-2">
                    <p class="font-bold text-slate-900">{{ $kos->nama_kos }}</p>
                    @include('partials.status', ['nilai' => $kos->status_kos])
                </div>
                <p class="mt-1 text-xs capitalize text-slate-500">Kos {{ $kos->jenis_kos }} · {{ $kos->kamar_count }} kamar</p>
            </a>
        @empty
            <p class="mt-4 rounded-xl bg-surface px-4 py-8 text-center text-sm text-slate-600">Belum ada kos.</p>
        @endforelse
    </section>
</div>
@endsection
