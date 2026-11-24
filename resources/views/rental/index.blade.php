@extends('booking.layout')
@section('title', 'Sewa')

@section('content')
<h1 class="text-2xl font-bold mb-4">Daftar Sewa</h1>

@forelse($rentals as $r)
    <a href="{{ route('rental.show', $r) }}" class="block bg-white p-5 rounded shadow mb-3 hover:bg-gray-50">
        <div class="flex justify-between">
            <div>
                <h3 class="font-bold">Kamar {{ $r->kamar->nomor_kamar ?? '-' }}</h3>
                @if(auth()->user()->isPemilik())
                    <p class="text-sm text-gray-600">Penyewa: {{ $r->pencari->name ?? '-' }}</p>
                @endif
                <p class="text-sm text-gray-600">
                    {{ $r->tanggal_mulai->format('d M Y') }} &ndash; {{ $r->tanggal_selesai->format('d M Y') }}
                </p>
            </div>
            <span class="px-3 py-1 rounded text-sm h-fit bg-emerald-50">{{ ucfirst($r->status_sewa) }}</span>
        </div>
    </a>
@empty
    <p class="text-gray-600">Belum ada data sewa.</p>
@endforelse
@endsection