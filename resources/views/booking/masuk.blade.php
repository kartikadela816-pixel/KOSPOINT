@extends('booking.layout')
@section('title', 'Booking Masuk')

@section('content')
<h1 class="text-2xl font-bold mb-4">Booking Masuk</h1>

@forelse($bookings as $b)
    <div class="bg-white p-5 rounded shadow mb-3">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="font-bold">
                    {{ $b->pencari->name ?? '-' }}
                    &mdash; Kamar {{ $b->kamar->nomor_kamar ?? '-' }}
                </h3>
                <p class="text-sm text-gray-600">
                    Masuk: {{ $b->tanggal_masuk_rencana->format('d M Y') }}
                    &middot; Lama: {{ $b->lama_sewa_bulan }} bulan
                </p>
                @if($b->catatan_pencari)
                    <p class="text-sm mt-1">Catatan: {{ $b->catatan_pencari }}</p>
                @endif
            </div>
            <span class="px-3 py-1 rounded text-sm bg-gray-100">{{ ucfirst($b->status_booking) }}</span>
        </div>

        @if($b->status_booking === 'menunggu')
            <div class="mt-3 flex flex-wrap gap-2 items-start">
                <form action="{{ route('pemilik.booking.terima', $b) }}" method="POST" class="flex gap-2">
                    @csrf
                    @method('PATCH')
                    <input type="text" name="catatan_pemilik" placeholder="Catatan (opsional)"
                           class="border p-1 rounded text-sm">
                    <button class="bg-green-600 text-white px-3 py-1 rounded">Terima</button>
                </form>

                <form action="{{ route('pemilik.booking.tolak', $b) }}" method="POST" class="flex gap-2">
                    @csrf
                    @method('PATCH')
                    <input type="text" name="catatan_pemilik" placeholder="Alasan (opsional)"
                           class="border p-1 rounded text-sm">
                    <button class="bg-red-500 text-white px-3 py-1 rounded">Tolak</button>
                </form>
            </div>
        @endif
    </div>
@empty
    <p class="text-gray-600">Belum ada booking masuk.</p>
@endforelse
@endsection