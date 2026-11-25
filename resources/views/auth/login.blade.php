@extends('layouts.app')

@section('polos', 'ya')

@section('title', 'Masuk — KOSPOINT')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-[radial-gradient(circle_at_top,#e6f6ec,#f8f9ff_55%)] px-4 py-10">
    <div class="kp-kartu w-full max-w-md p-6 shadow-xl shadow-brand-700/5 md:p-8">
        <div class="text-center">
            @include('partials.logo-mark', ['ukuran' => 'mx-auto h-14 w-14 rounded-2xl', 'ikon' => 'h-8 w-8'])
            <a href="{{ route('beranda') }}" class="mt-3 block text-xl font-extrabold tracking-tight text-brand-900">KOSPOINT</a>
            <p class="mx-auto mt-2 max-w-xs text-sm leading-6 text-slate-500">
                Temukan hunian idaman atau kelola kos dengan aman dan terpercaya.
            </p>
        </div>

        <h1 class="mt-6 text-2xl font-extrabold text-slate-900">Masuk</h1>

        <form action="{{ route('login.store') }}" method="POST" class="mt-5 space-y-4">
            @csrf

            <div>
                <label for="email" class="kp-label">Email</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v12H4zM4 7l8 6 8-6" /></svg>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email"
                           class="kp-input pl-11">
                </div>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="kp-label">Password</label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 11h12v9H6zM8 11V8a4 4 0 0 1 8 0v3" /></svg>
                    <input id="password" type="password" name="password" placeholder="Masukkan password" autocomplete="current-password"
                           class="kp-input pl-11 pr-12">
                    <button type="button" data-lihat-sandi="password" class="absolute inset-y-0 right-3 text-slate-400 hover:text-slate-600" aria-label="Lihat kata sandi">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12z" />
                            <circle cx="12" cy="12" r="2.5" />
                        </svg>
                    </button>
                </div>
            </div>

            <button class="kp-tombol w-full">Masuk</button>
        </form>

        <p class="mt-5 text-center text-sm text-slate-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-brand-700 hover:text-brand-800">Daftar di sini</a>
        </p>

        <a href="{{ route('beranda') }}"
           class="mt-4 flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:border-brand-200 hover:bg-brand-50 hover:text-brand-800">
            <span aria-hidden="true">←</span>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
