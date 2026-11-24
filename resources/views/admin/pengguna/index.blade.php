@extends('layouts.dashboard')

@section('title', 'Pengguna — KOSPOINT')

@section('content')
<x-halaman-judul judul="Pengguna" sub="Kelola akun admin, pemilik kos, dan pencari kos.">
    <a href="{{ route('admin.pengguna.create') }}" class="kp-tombol">+ Tambah Pengguna</a>
</x-halaman-judul>

<form method="GET" class="kp-kartu mb-4 flex flex-col gap-2 p-3 sm:flex-row">
    <label for="q" class="sr-only">Cari pengguna</label>
    <input id="q" type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email..." class="kp-input sm:flex-1">
    <label for="role" class="sr-only">Role</label>
    <select id="role" name="role" class="kp-input sm:w-44">
        <option value="">Semua role</option>
        @foreach (['admin' => 'Admin', 'pemilik' => 'Pemilik', 'pencari' => 'Pencari'] as $nilai => $teks)
            <option value="{{ $nilai }}" @selected(request('role') === $nilai)>{{ $teks }}</option>
        @endforeach
    </select>
    <button class="kp-tombol">Cari</button>
    @if (request()->hasAny(['q', 'role']))
        <a href="{{ route('admin.pengguna.index') }}" class="kp-tombol-sekunder">Reset</a>
    @endif
</form>

@if ($pengguna->isEmpty())
    <div class="rounded-2xl border border-dashed border-brand-200 bg-white px-6 py-12 text-center">
        <p class="font-semibold text-slate-800">Pengguna tidak ditemukan.</p>
    </div>
@else
    <div class="kp-kartu hidden overflow-hidden md:block">
        <table class="w-full text-left text-sm">
            <thead class="bg-surface text-xs font-bold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Pengguna</th>
                    <th class="px-4 py-3">Nomor HP</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($pengguna as $u)
                    <tr class="align-middle">
                        <td class="px-4 py-3">
                            <p class="font-bold text-slate-900">{{ $u->name }}@if ($u->id === auth()->id()) <span class="text-xs font-medium text-slate-500">(Anda)</span>@endif</p>
                            <p class="text-xs text-slate-500">{{ $u->email }}</p>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $u->nomor_hp ?: '-' }}</td>
                        <td class="px-4 py-3">@include('partials.status', ['nilai' => $u->role])</td>
                        <td class="px-4 py-3">@include('partials.status', ['nilai' => $u->status_akun])</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end">
                                @include('partials.aksi-baris', [
                                    'ubah' => route('admin.pengguna.edit', $u->id),
                                    'hapus' => route('admin.pengguna.destroy', $u->id),
                                    'konfirmasi' => 'Hapus pengguna '.$u->name.'?',
                                ])
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="space-y-3 md:hidden">
        @foreach ($pengguna as $u)
            <article class="kp-kartu p-4">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="font-bold text-slate-900">{{ $u->name }}@if ($u->id === auth()->id()) <span class="text-xs font-medium text-slate-500">(Anda)</span>@endif</p>
                        <p class="truncate text-xs text-slate-500">{{ $u->email }}</p>
                    </div>
                    @include('partials.status', ['nilai' => $u->role])
                </div>
                <p class="mt-2 flex items-center gap-2 text-sm text-slate-600">
                    {{ $u->nomor_hp ?: '-' }} · @include('partials.status', ['nilai' => $u->status_akun])
                </p>
                <div class="mt-3">
                    @include('partials.aksi-baris', [
                        'ubah' => route('admin.pengguna.edit', $u->id),
                        'hapus' => route('admin.pengguna.destroy', $u->id),
                        'konfirmasi' => 'Hapus pengguna '.$u->name.'?',
                    ])
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-4">{{ $pengguna->links() }}</div>
@endif
@endsection
