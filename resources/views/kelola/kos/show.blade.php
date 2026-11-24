@extends('layouts.dashboard')

@section('title', $kos->nama_kos.' — KOSPOINT')

@section('content')
@php
    $perStatus = $kos->kamar->countBy('status_kamar');
    $warnaDenah = [
        'tersedia' => 'bg-brand-100 text-brand-900',
        'terisi' => 'bg-brand-700 text-white',
        'dipesan' => 'bg-amber-100 text-amber-900',
        'nonaktif' => 'bg-slate-200 text-slate-600',
    ];
@endphp

<x-halaman-judul :judul="$kos->nama_kos" :kembali="route($prefix.'.kos.index')" teksKembali="Daftar kos">
    <a href="{{ route($prefix.'.kos.edit', $kos->id) }}" class="kp-tombol-sekunder">Edit Kos</a>
    <a href="{{ route($prefix.'.kos.kamar.create', $kos->id) }}" class="kp-tombol">+ Tambah Kamar</a>
</x-halaman-judul>

<div class="grid gap-4 lg:grid-cols-3">
    {{-- Detail kos --}}
    <section class="kp-kartu p-5 lg:col-span-2">
        <div class="flex flex-wrap items-center gap-2">
            @include('partials.status', ['nilai' => $kos->status_kos])
            <span class="kp-lencana capitalize">Kos {{ $kos->jenis_kos }}</span>
        </div>
        <p class="mt-3 text-slate-700">{{ $kos->alamat }}</p>
        @if ($kos->latitude && $kos->longitude)
            <a href="https://www.google.com/maps?q={{ $kos->latitude }},{{ $kos->longitude }}" target="_blank" rel="noopener"
               class="mt-1 inline-block text-sm font-semibold text-brand-700 hover:text-brand-800">Buka di Google Maps &rsaquo;</a>
        @endif

        @if ($kos->deskripsi)
            <h2 class="mt-5 text-sm font-bold text-slate-900">Deskripsi</h2>
            <p class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $kos->deskripsi }}</p>
        @endif
        @if ($kos->aturan_kos)
            <h2 class="mt-5 text-sm font-bold text-slate-900">Aturan kos</h2>
            <p class="mt-1 whitespace-pre-line text-sm leading-6 text-slate-600">{{ $kos->aturan_kos }}</p>
        @endif
    </section>

    {{-- Kontak dan ringkasan kamar --}}
    <div class="space-y-4">
        <section class="kp-kartu p-5">
            <h2 class="text-sm font-bold text-slate-900">Kontak</h2>
            <dl class="mt-3 space-y-2 text-sm">
                <div><dt class="text-slate-500">WhatsApp</dt><dd class="font-semibold">{{ $kos->nomor_whatsapp ?: '-' }}</dd></div>
                <div><dt class="text-slate-500">Telepon</dt><dd class="font-semibold">{{ $kos->nomor_telepon ?: '-' }}</dd></div>
                @if ($prefix === 'admin')
                    <div><dt class="text-slate-500">Pemilik</dt><dd class="font-semibold">{{ $kos->pemilik?->name ?? '-' }}</dd></div>
                @endif
            </dl>
        </section>

        <section class="kp-kartu p-5">
            <h2 class="text-sm font-bold text-slate-900">Ringkasan kamar</h2>
            <div class="mt-3 grid grid-cols-2 gap-2 text-center text-sm">
                @foreach (['tersedia' => 'Tersedia', 'terisi' => 'Terisi', 'dipesan' => 'Dipesan', 'nonaktif' => 'Nonaktif'] as $kunci => $teks)
                    <div class="rounded-xl p-3 {{ $warnaDenah[$kunci] }}">
                        <p class="text-xl font-extrabold">{{ $perStatus[$kunci] ?? 0 }}</p>
                        <p class="text-xs font-semibold">{{ $teks }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</div>

{{-- Daftar kamar --}}
<h2 class="mb-3 mt-8 text-xl font-extrabold text-slate-900">Daftar Kamar</h2>

@if ($kos->kamar->isEmpty())
    <div class="rounded-2xl border border-dashed border-brand-200 bg-white px-6 py-12 text-center">
        <p class="font-semibold text-slate-800">Belum ada kamar.</p>
        <a href="{{ route($prefix.'.kos.kamar.create', $kos->id) }}" class="kp-tombol mt-4">+ Tambah Kamar</a>
    </div>
@else
    <div class="kp-kartu hidden overflow-hidden md:block">
        <table class="w-full text-left text-sm">
            <thead class="bg-surface text-xs font-bold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Kamar</th>
                    <th class="px-4 py-3">Harga / bulan</th>
                    <th class="px-4 py-3">Jaminan</th>
                    <th class="px-4 py-3">Kamar mandi</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($kos->kamar as $kamar)
                    <tr class="align-middle">
                        <td class="px-4 py-3">
                            <p class="font-bold text-slate-900">{{ $kamar->nomor_kamar }}</p>
                            @if ($kamar->nama_kamar)<p class="text-xs text-slate-500">{{ $kamar->nama_kamar }}</p>@endif
                        </td>
                        <td class="px-4 py-3 font-semibold text-brand-800">Rp {{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-slate-600">Rp {{ number_format($kamar->uang_jaminan, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 capitalize text-slate-600">{{ $kamar->jenis_kamar_mandi }}</td>
                        <td class="px-4 py-3">@include('partials.status', ['nilai' => $kamar->status_kamar])</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end">
                                @include('partials.aksi-baris', [
                                    'ubah' => route($prefix.'.kamar.edit', $kamar->id),
                                    'hapus' => route($prefix.'.kamar.destroy', $kamar->id),
                                    'konfirmasi' => 'Hapus kamar '.$kamar->nomor_kamar.'?',
                                ])
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="space-y-3 md:hidden">
        @foreach ($kos->kamar as $kamar)
            <article class="kp-kartu p-4">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="font-bold text-slate-900">Kamar {{ $kamar->nomor_kamar }}</p>
                        @if ($kamar->nama_kamar)<p class="text-xs text-slate-500">{{ $kamar->nama_kamar }}</p>@endif
                    </div>
                    @include('partials.status', ['nilai' => $kamar->status_kamar])
                </div>
                <p class="mt-2 font-bold text-brand-800">Rp {{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}<span class="text-xs font-medium text-slate-500"> / bulan</span></p>
                <p class="mt-1 text-sm capitalize text-slate-600">Kamar mandi {{ $kamar->jenis_kamar_mandi }} · Jaminan Rp {{ number_format($kamar->uang_jaminan, 0, ',', '.') }}</p>
                <div class="mt-3">
                    @include('partials.aksi-baris', [
                        'ubah' => route($prefix.'.kamar.edit', $kamar->id),
                        'hapus' => route($prefix.'.kamar.destroy', $kamar->id),
                        'konfirmasi' => 'Hapus kamar '.$kamar->nomor_kamar.'?',
                    ])
                </div>
            </article>
        @endforeach
    </div>
@endif
@endsection
