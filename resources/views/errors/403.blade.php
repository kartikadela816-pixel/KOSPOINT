@extends('layouts.app')

@section('title', 'Akses ditolak — KOSPOINT')

@section('content')
<div class="mx-auto max-w-md px-4 py-20 text-center">
    <p class="text-5xl font-extrabold text-brand-700">403</p>
    <h1 class="mt-3 text-2xl font-extrabold text-slate-900">Akses ditolak</h1>
    <p class="mt-2 text-slate-600">Akun Anda tidak memiliki izin untuk membuka halaman ini.</p>
    <a href="{{ route('beranda') }}" class="kp-tombol mt-6">Kembali ke Beranda</a>
</div>
@endsection
