@extends('layouts.dashboard')

@section('title', ($prefix === 'admin' ? 'Kos & Kamar' : 'Kos Saya').' — KOSPOINT')

@section('content')
<x-halaman-judul :judul="$prefix === 'admin' ? 'Kos & Kamar' : 'Kos Saya'"
                 :sub="$prefix === 'admin' ? 'Kelola seluruh kos dan kamar yang terdaftar.' : 'Kelola kos dan kamar milik Anda.'">
    <a href="{{ route($prefix.'.kos.create') }}" class="kp-tombol">+ Tambah Kos</a>
</x-halaman-judul>

<form method="GET" class="kp-kartu mb-4 flex flex-col gap-2 p-3 sm:flex-row">
    <label for="q" class="sr-only">Cari kos</label>
    <input id="q" type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama kos atau alamat..." class="kp-input sm:flex-1">
    <label for="status" class="sr-only">Status</label>
    <select id="status" name="status" class="kp-input sm:w-44">
        <option value="">Semua status</option>
        @foreach (['aktif' => 'Aktif', 'draft' => 'Draft', 'nonaktif' => 'Nonaktif'] as $nilai => $teks)
            <option value="{{ $nilai }}" @selected(request('status') === $nilai)>{{ $teks }}</option>
        @endforeach
    </select>
    <button class="kp-tombol">Cari</button>
    @if (request()->hasAny(['q', 'status']))
        <a href="{{ route($prefix.'.kos.index') }}" class="kp-tombol-sekunder">Reset</a>
    @endif
</form>

@if ($kos->isEmpty())
    <div class="rounded-2xl border border-dashed border-brand-200 bg-white px-6 py-12 text-center">
        <p class="font-semibold text-slate-800">Belum ada kos.</p>
        <p class="mt-1 text-sm text-slate-600">Tambahkan kos pertama untuk mulai mengelola kamar.</p>
    </div>
@else
    {{-- Tabel untuk desktop --}}
    <div class="kp-kartu hidden overflow-hidden md:block">
        <table class="w-full text-left text-sm">
            <thead class="bg-surface text-xs font-bold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Kos</th>
                    @if ($prefix === 'admin')<th class="px-4 py-3">Pemilik</th>@endif
                    <th class="px-4 py-3">Jenis</th>
                    <th class="px-4 py-3">Kamar</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($kos as $item)
                    <tr class="align-middle">
                        <td class="px-4 py-3">
                            <a href="{{ route($prefix.'.kos.show', $item->id) }}" class="font-bold text-slate-900 hover:text-brand-700">{{ $item->nama_kos }}</a>
                            <p class="mt-0.5 max-w-xs truncate text-xs text-slate-500">{{ $item->alamat }}</p>
                        </td>
                        @if ($prefix === 'admin')<td class="px-4 py-3 text-slate-600">{{ $item->pemilik?->name ?? '-' }}</td>@endif
                        <td class="px-4 py-3 capitalize text-slate-600">{{ $item->jenis_kos }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $item->kamar_count }}</td>
                        <td class="px-4 py-3">@include('partials.status', ['nilai' => $item->status_kos])</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end">
                                @include('partials.aksi-baris', [
                                    'lihat' => route($prefix.'.kos.show', $item->id),
                                    'ubah' => route($prefix.'.kos.edit', $item->id),
                                    'hapus' => route($prefix.'.kos.destroy', $item->id),
                                    'konfirmasi' => 'Hapus kos "'.$item->nama_kos.'"?',
                                ])
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Kartu untuk mobile --}}
    <div class="space-y-3 md:hidden">
        @foreach ($kos as $item)
            <article class="kp-kartu p-4">
                <div class="flex items-start justify-between gap-3">
                    <a href="{{ route($prefix.'.kos.show', $item->id) }}" class="font-bold text-slate-900">{{ $item->nama_kos }}</a>
                    @include('partials.status', ['nilai' => $item->status_kos])
                </div>
                <p class="mt-1 text-sm text-slate-500">{{ $item->alamat }}</p>
                <p class="mt-2 text-sm text-slate-600">
                    <span class="capitalize">{{ $item->jenis_kos }}</span> · {{ $item->kamar_count }} kamar
                    @if ($prefix === 'admin') · {{ $item->pemilik?->name ?? '-' }} @endif
                </p>
                <div class="mt-3">
                    @include('partials.aksi-baris', [
                        'lihat' => route($prefix.'.kos.show', $item->id),
                        'ubah' => route($prefix.'.kos.edit', $item->id),
                        'hapus' => route($prefix.'.kos.destroy', $item->id),
                        'konfirmasi' => 'Hapus kos "'.$item->nama_kos.'"?',
                    ])
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-4">{{ $kos->links() }}</div>
@endif
@endsection
