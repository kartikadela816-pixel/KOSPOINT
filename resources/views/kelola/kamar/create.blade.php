@extends('layouts.dashboard')

@section('title', 'Tambah Kamar — KOSPOINT')

@section('content')
<x-halaman-judul judul="Tambah Kamar" :sub="$kos->nama_kos" :kembali="route($prefix.'.kos.show', $kos->id)" teksKembali="Detail kos" />

<form action="{{ route($prefix.'.kos.kamar.store', $kos->id) }}" method="POST" class="max-w-3xl">
    @csrf
    @include('kelola.kamar._form', ['batal' => route($prefix.'.kos.show', $kos->id)])
</form>
@endsection
