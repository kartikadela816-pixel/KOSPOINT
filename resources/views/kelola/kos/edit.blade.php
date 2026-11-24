@extends('layouts.dashboard')

@section('title', 'Edit Kos — KOSPOINT')

@section('content')
<x-halaman-judul :judul="'Edit '.$kos->nama_kos" :kembali="route($prefix.'.kos.show', $kos->id)" teksKembali="Detail kos" />

<form action="{{ route($prefix.'.kos.update', $kos->id) }}" method="POST" class="max-w-3xl">
    @csrf
    @method('PUT')
    @include('kelola.kos._form', ['batal' => route($prefix.'.kos.show', $kos->id)])
</form>
@endsection
