@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Ulasan Kos Saya
        </h1>
        <p class="text-gray-600 mt-1">
            Lihat penilaian dan komentar dari penyewa kos milikmu.
        </p>
    </div>

    @if($reviews->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-600">
                Belum ada ulasan untuk kos milikmu.
            </p>
        </div>
    @else

            @foreach($reviews->filter(fn($review) => $review->rental?->kamar?->kos)->groupBy(fn($review) => $review->rental->kamar->kos->id) as $kosReviews)

            @php
                $kos = $kosReviews->first()->rental->kamar->kos;
                $rataRata = $kosReviews->avg('rating');
            @endphp

            <div class="bg-white rounded-lg shadow p-5 mb-4">
                <h2 class="text-lg font-bold text-gray-800">
                    {{ $kos->nama_kos }}
                </h2>

                <p class="text-gray-600 mt-2">
                    Rata-rata Rating:
                </p>

                <p class="text-xl font-bold text-yellow-500">
                    &#9733; {{ number_format($rataRata, 1) }}/5
                </p>

                <p class="text-sm text-gray-500">
                    Dari {{ $kosReviews->count() }} ulasan
                </p>
            </div>

        @endforeach

        <div class="mb-4 bg-white rounded-lg shadow p-5">
            <p class="text-gray-600">Total ulasan</p>
            <p class="text-3xl font-bold text-blue-900">
                {{ $reviews->count() }}
            </p>
        </div>

        @foreach($reviews as $review)
            <div class="bg-white rounded-lg shadow p-6 mb-5">

                <h2 class="text-lg font-bold text-gray-800">
                    {{ $review->rental?->kamar?->kos?->nama_kos ?? 'Nama kos tidak tersedia' }}
                </h2>

                <p class="text-gray-600 mt-1">
                    Kamar:
                    {{ $review->rental?->kamar?->nama_kamar ?? $review->rental?->kamar?->nomor_kamar ?? '-' }}
                </p>

                <div class="mt-3">
                    <span class="text-yellow-500 text-xl">
                        {!! str_repeat('&#9733;', $review->rating) !!}
                    </span>
                    <span class="font-semibold">
                        {{ $review->rating }}/5
                    </span>
                </div>

                <p class="text-gray-700 mt-3">
                    {{ $review->komentar ?? 'Penyewa tidak memberikan komentar.' }}
                </p>

                <p class="text-xs text-gray-400 mt-4">
                    Dikirim pada:
                    {{ $review->created_at?->format('d-m-Y H:i') ?? '-' }}
                </p>

            </div>
        @endforeach

    @endif

</div>
@endsection
