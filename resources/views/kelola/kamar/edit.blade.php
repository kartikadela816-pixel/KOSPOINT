@extends('layouts.dashboard')

@section('title', 'Edit Kamar — KOSPOINT')

@section('content')
<x-halaman-judul :judul="'Edit Kamar '.$kamar->nomor_kamar" :sub="$kos->nama_kos" :kembali="route($prefix.'.kos.show', $kos->id)" teksKembali="Detail kos" />

<form action="{{ route($prefix.'.kamar.update', $kamar->id) }}" method="POST" class="max-w-3xl">
    @csrf
    @method('PUT')
    @include('kelola.kamar._form', ['batal' => route($prefix.'.kos.show', $kos->id)])
</form>
@endsection
