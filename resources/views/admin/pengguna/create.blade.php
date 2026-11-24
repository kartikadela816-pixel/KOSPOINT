@extends('layouts.dashboard')

@section('title', 'Tambah Pengguna — KOSPOINT')

@section('content')
<x-halaman-judul judul="Tambah Pengguna" :kembali="route('admin.pengguna.index')" teksKembali="Daftar pengguna" />

<form action="{{ route('admin.pengguna.store') }}" method="POST" class="max-w-3xl">
    @csrf
    @include('admin.pengguna._form', ['baru' => true, 'batal' => route('admin.pengguna.index')])
</form>
@endsection
