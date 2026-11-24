@extends('layouts.dashboard')

@section('title', 'Tambah Kos — KOSPOINT')

@section('content')
<x-halaman-judul judul="Tambah Kos" sub="Isi data kos. Kamar bisa ditambahkan setelah kos tersimpan."
                 :kembali="route($prefix.'.kos.index')" teksKembali="Daftar kos" />

<form action="{{ route($prefix.'.kos.store') }}" method="POST" class="max-w-3xl">
    @csrf
    @include('kelola.kos._form', ['batal' => route($prefix.'.kos.index')])
</form>
@endsection
