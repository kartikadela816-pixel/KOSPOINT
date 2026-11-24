@extends('booking.layout')
@section('title', 'Detail Sewa')

@section('content')
<a href="{{ route('rental.index') }}" class="text-blue-900">&larr; Kembali</a>
<h1 class="text-2xl font-bold my-4">Detail Sewa</h1>

<div class="bg-white p-6 rounded shadow">
    <dl class="grid md:grid-cols-2 gap-4">
        <div><dt class="text-gray-500 text-sm">Kamar</dt>
             <dd class="font-semibold">{{ $rental->kamar->nomor_kamar ?? '-' }}</dd></div>
        <div><dt class="text-gray-500 text-sm">Penyewa</dt>
             <dd class="font-semibold">{{ $rental->pencari->name ?? '-' }}</dd></div>
        <div><dt class="text-gray-500 text-sm">Mulai</dt>
             <dd class="font-semibold">{{ $rental->tanggal_mulai->format('d M Y') }}</dd></div>
        <div><dt class="text-gray-500 text-sm">Selesai</dt>
             <dd class="font-semibold">{{ $rental->tanggal_selesai->format('d M Y') }}</dd></div>
        <div><dt class="text-gray-500 text-sm">Harga per bulan</dt>
             <dd class="font-semibold">Rp {{ number_format($rental->harga_per_bulan, 0, ',', '.') }}</dd></div>
        <div><dt class="text-gray-500 text-sm">Uang jaminan</dt>
             <dd class="font-semibold">Rp {{ number_format($rental->uang_jaminan, 0, ',', '.') }}</dd></div>
        <div><dt class="text-gray-500 text-sm">Status sewa</dt>
             <dd class="font-semibold">{{ ucfirst($rental->status_sewa) }}</dd></div>
        <div><dt class="text-gray-500 text-sm">Perpanjangan</dt>
             <dd class="font-semibold">{{ ucfirst(str_replace('_', ' ', $rental->status_perpanjangan)) }}</dd></div>
    </dl>
</div>
@endsection