@extends('layouts.dashboard')

@section('title', 'Dashboard Admin — KOSPOINT')

@section('content')
<section class="kp-kartu flex flex-col gap-4 p-5 md:flex-row md:items-center md:justify-between md:p-6">
    <div>
        <p class="kp-lencana">Panel admin</p>
        <h1 class="mt-3 text-2xl font-extrabold tracking-tight text-slate-900 md:text-3xl">Selamat datang, {{ auth()->user()->name }}</h1>
        <p class="mt-1 text-slate-600">Ringkasan pengguna, kos, dan kamar di KOSPOINT.</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.pengguna.create') }}" class="kp-tombol">+ Tambah Pengguna</a>
        <a href="{{ route('admin.kos.create') }}" class="kp-tombol-sekunder">+ Tambah Kos</a>
    </div>
</section>

<div class="mt-4 grid grid-cols-2 gap-4 lg:grid-cols-4">
    <div class="kp-kartu border-t-4 border-t-brand-700 p-4">
        <p class="text-sm text-slate-500">Total pengguna</p>
        <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ $penggunaPerRole->sum() }}</p>
        <p class="mt-1 text-xs text-brand-700">{{ $penggunaPerRole['pemilik'] ?? 0 }} pemilik · {{ $penggunaPerRole['pencari'] ?? 0 }} pencari</p>
    </div>
    <div class="kp-kartu border-t-4 border-t-brand-600 p-4">
        <p class="text-sm text-slate-500">Total kos</p>
        <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ $totalKos }}</p>
        <p class="mt-1 text-xs text-brand-700">{{ $kosPerStatus['aktif'] ?? 0 }} aktif</p>
    </div>
    <div class="kp-kartu border-t-4 border-t-amber-500 p-4">
        <p class="text-sm text-slate-500">Kos draft</p>
        <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ $kosPerStatus['draft'] ?? 0 }}</p>
        <p class="mt-1 text-xs text-amber-700">belum dipublikasikan</p>
    </div>
    <div class="kp-kartu border-t-4 border-t-brand-200 p-4">
        <p class="text-sm text-slate-500">Total kamar</p>
        <p class="mt-1 text-3xl font-extrabold text-slate-900">{{ $totalKamar }}</p>
    </div>
</div>

<div class="mt-4 grid gap-4 lg:grid-cols-2">
    <section class="kp-kartu p-5">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-slate-900">Pengguna Terbaru</h2>
            <a href="{{ route('admin.pengguna.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-800">Lihat semua</a>
        </div>
        <ul class="mt-3 divide-y divide-slate-100">
            @foreach ($penggunaTerbaru as $u)
                <li class="flex items-center justify-between gap-3 py-2.5">
                    <div class="min-w-0">
                        <p class="truncate font-semibold text-slate-900">{{ $u->name }}</p>
                        <p class="truncate text-xs text-slate-500">{{ $u->email }}</p>
                    </div>
                    @include('partials.status', ['nilai' => $u->role])
                </li>
            @endforeach
        </ul>
    </section>

    <section class="kp-kartu p-5">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-slate-900">Kos Terbaru</h2>
            <a href="{{ route('admin.kos.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-800">Lihat semua</a>
        </div>
        <ul class="mt-3 divide-y divide-slate-100">
            @forelse ($kosTerbaru as $kos)
                <li class="flex items-center justify-between gap-3 py-2.5">
                    <div class="min-w-0">
                        <a href="{{ route('admin.kos.show', $kos->id) }}" class="block truncate font-semibold text-slate-900 hover:text-brand-700">{{ $kos->nama_kos }}</a>
                        <p class="truncate text-xs text-slate-500">{{ $kos->pemilik?->name ?? '-' }} · {{ $kos->kamar_count }} kamar</p>
                    </div>
                    @include('partials.status', ['nilai' => $kos->status_kos])
                </li>
            @empty
                <li class="py-6 text-center text-sm text-slate-600">Belum ada kos.</li>
            @endforelse
        </ul>
    </section>
</div>
@endsection
