@extends('booking.layout')
@section('title', 'Booking Saya')

@section('content')
<h1 class="text-2xl font-bold mb-4">Booking Saya</h1>

@forelse($bookings as $b)
    <div class="bg-white p-5 rounded shadow mb-3">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="font-bold">
                    Kamar {{ $b->kamar->nomor_kamar ?? '-' }}
                    @if($b->kamar?->nama_kamar) ({{ $b->kamar->nama_kamar }}) @endif
                </h3>
                <p class="text-sm text-gray-600">
                    Masuk: {{ $b->tanggal_masuk_rencana->format('d M Y') }}
                    &middot; Lama: {{ $b->lama_sewa_bulan }} bulan
                </p>
                @if($b->catatan_pencari)
                    <p class="text-sm mt-1">Catatan kamu: {{ $b->catatan_pencari }}</p>
                @endif
                @if($b->catatan_pemilik)
                    <p class="text-sm mt-1">Tanggapan pemilik: {{ $b->catatan_pemilik }}</p>
                @endif
            </div>

            @php
                $warna = [
                    'menunggu' => 'bg-yellow-100 text-yellow-800',
                    'diterima' => 'bg-green-100 text-green-800',
                    'ditolak' => 'bg-red-100 text-red-800',
                    'dibatalkan' => 'bg-gray-200 text-gray-700',
                ][$b->status_booking] ?? 'bg-gray-100';
            @endphp
            <span class="px-3 py-1 rounded text-sm {{ $warna }}">{{ ucfirst($b->status_booking) }}</span>
        </div>

        <div class="mt-3 flex gap-2">
            @if($b->status_booking === 'menunggu')
                <form action="{{ route('booking.batal', $b) }}" method="POST"
                      onsubmit="return confirm('Batalkan booking ini?')">
                    @csrf
                    @method('PATCH')
                    <button class="bg-red-500 text-white px-3 py-1 rounded">Batalkan</button>
                </form>
            @endif

            @if($b->rental)
                <a href="{{ route('rental.show', $b->rental) }}"
                   class="bg-blue-900 text-white px-3 py-1 rounded">Lihat Sewa</a>
            @endif
        </div>
    </div>
@empty
    <p class="text-gray-600">Belum ada booking.</p>
@endforelse
@endsection