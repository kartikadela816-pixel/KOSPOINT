{{-- Pencari memakai layout publik, pemilik dan admin memakai layout dasbor. --}}
@extends(auth()->user()->isPencari() ? 'layouts.app' : 'layouts.dashboard')

@section('title', 'Profil — KOSPOINT')

@section('content')
@php
    $namaPeran = match ($pengguna->role) {
        'pemilik' => 'Pemilik Kos',
        'admin' => 'Admin',
        default => 'Pencari Kos',
    };
    $pembungkus = $pengguna->isPencari() ? 'mx-auto max-w-3xl px-4 py-8' : '';
@endphp

<div class="{{ $pembungkus }}">
    @if ($pengguna->isPencari())
        @include('partials.flash')
    @endif

    <x-halaman-judul judul="Profil Saya" sub="Kelola data diri dan keamanan akun." />

    <div class="max-w-3xl space-y-4">
        <section class="kp-kartu flex items-center gap-4 p-5">
            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-brand-700 text-xl font-extrabold text-white" aria-hidden="true">{{ mb_strtoupper(mb_substr($pengguna->name, 0, 1)) }}</span>
            <div class="min-w-0">
                <p class="truncate text-lg font-extrabold text-slate-900">{{ $pengguna->name }}</p>
                <p class="mt-0.5 flex flex-wrap items-center gap-2 text-sm text-slate-500">
                    {{ $namaPeran }} @include('partials.status', ['nilai' => $pengguna->status_akun])
                </p>
            </div>
        </section>

        <form action="{{ route('profil.update') }}" method="POST" class="kp-kartu p-5">
            @csrf
            @method('PUT')
            <h2 class="mb-4 font-bold text-slate-900">Data diri</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <x-field name="name" label="Nama" required :value="$pengguna->name" class="sm:col-span-2" />
                <x-field name="email" label="Email" type="email" required :value="$pengguna->email" />
                <x-field name="nomor_hp" label="Nomor HP" type="tel" :value="$pengguna->nomor_hp" />
            </div>
            <div class="mt-5 flex justify-end"><button class="kp-tombol">Simpan Profil</button></div>
        </form>

        <form action="{{ route('profil.password') }}" method="POST" class="kp-kartu p-5">
            @csrf
            @method('PUT')
            <h2 class="mb-4 font-bold text-slate-900">Ganti password</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <x-field name="current_password" label="Password saat ini" type="password" required bag="password" autocomplete="current-password" class="sm:col-span-2" />
                <x-field name="password" label="Password baru" type="password" required bag="password" autocomplete="new-password" hint="Minimal 6 karakter." />
                <x-field name="password_confirmation" label="Konfirmasi password baru" type="password" required bag="password" autocomplete="new-password" />
            </div>
            <div class="mt-5 flex justify-end"><button class="kp-tombol">Ganti Password</button></div>
        </form>
    </div>
</div>
@endsection
