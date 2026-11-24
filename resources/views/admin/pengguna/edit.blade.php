@extends('layouts.dashboard')

@section('title', 'Edit Pengguna — KOSPOINT')

@section('content')
<x-halaman-judul :judul="'Edit '.$pengguna->name" :kembali="route('admin.pengguna.index')" teksKembali="Daftar pengguna" />

<form action="{{ route('admin.pengguna.update', $pengguna->id) }}" method="POST" class="max-w-3xl">
    @csrf
    @method('PUT')
    @include('admin.pengguna._form', ['baru' => false, 'batal' => route('admin.pengguna.index')])
</form>
@endsection
