@extends('layouts.app')

@section('polos', 'ya')

@section('title', 'Daftar — KOSPOINT')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-[radial-gradient(circle_at_top,#e6f6ec,#f8f9ff_55%)] px-4 py-10">
    <div class="kp-kartu w-full max-w-md p-6 shadow-xl shadow-brand-700/5 md:p-8">
        <div class="text-center">
            @include('partials.logo-mark', ['ukuran' => 'mx-auto h-14 w-14 rounded-2xl', 'ikon' => 'h-8 w-8'])
            <a href="{{ route('beranda') }}" class="mt-3 block text-xl font-extrabold tracking-tight text-brand-900">KOSPOINT</a>
            <p class="mx-auto mt-2 max-w-xs text-sm leading-6 text-slate-500">
                Buat akun pencari kos atau pemilik kos.
            </p>
        </div>

        <h1 class="mt-6 text-2xl font-extrabold text-slate-900">Registrasi</h1>

<a href="{{ route('beranda') }}"
   class="mt-3 inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-brand-700">
    ← Kembali ke Beranda
</a>

        <form action="{{ route('register.store') }}" method="POST" class="mt-5 space-y-4">
            @csrf

            <fieldset>
                <legend class="kp-label">Daftar Sebagai</legend>
                <div class="grid grid-cols-2 gap-1 rounded-2xl bg-surface p-1">
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="pencari" class="peer sr-only" @checked(old('role', $role) === 'pencari')>
                        <span class="flex items-center justify-center gap-2 rounded-xl bg-white px-3 py-2.5 text-sm font-semibold text-slate-600 shadow-none transition peer-checked:bg-brand-700 peer-checked:text-white peer-checked:shadow-sm peer-focus-visible:ring-2 peer-focus-visible:ring-brand-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM4 20a8 8 0 0 1 16 0" /></svg>
                            Pencari Kos
                        </span>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="role" value="pemilik" class="peer sr-only" @checked(old('role', $role) === 'pemilik')>
                        <span class="flex items-center justify-center gap-2 rounded-xl bg-white px-3 py-2.5 text-sm font-semibold text-slate-600 shadow-none transition peer-checked:bg-brand-700 peer-checked:text-white peer-checked:shadow-sm peer-focus-visible:ring-2 peer-focus-visible:ring-brand-600">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M6 21V10l6-5 6 5v11M10 21v-5h4v5" /></svg>
                            Pemilik Kos
                        </span>
                    </label>
                </div>
                @error('role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </fieldset>

            <div>
                <label for="name" class="kp-label">Nama</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM4 20a8 8 0 0 1 16 0" /></svg>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" autocomplete="name"
                           class="kp-input pl-11">
                </div>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="kp-label">Email</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v12H4zM4 7l8 6 8-6" /></svg>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email"
                           class="kp-input pl-11">
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nomor_hp" class="kp-label">Nomor HP</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 3h8v18H8zM11 18h2" /></svg>
                    <input id="nomor_hp" type="text" name="nomor_hp" value="{{ old('nomor_hp') }}" autocomplete="tel" inputmode="tel"
                           class="kp-input pl-11">
                </div>
                @error('nomor_hp')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="kp-label">Password</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 11h12v9H6zM8 11V8a4 4 0 0 1 8 0v3" /></svg>
                    <input id="password" type="password" name="password" autocomplete="new-password"
                           class="kp-input pl-11 pr-12">
                    <button type="button" data-lihat-sandi="password" class="absolute inset-y-0 right-3 text-slate-400 hover:text-slate-600" aria-label="Lihat kata sandi">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z" />
                            <circle cx="12" cy="12" r="2.5" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="kp-label">Konfirmasi Password</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 11h12v9H6zM8 11V8a4 4 0 0 1 8 0v3" /></svg>
                    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
                           class="kp-input pl-11">
                </div>
            </div>

            <button class="kp-tombol w-full">Daftar</button>
        </form>

        <p class="mt-5 text-center text-sm text-slate-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-brand-700 hover:text-brand-800">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection
