@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Ulasan Kos</h1>
        <p class="text-gray-600 mt-1">
            Berikan penilaian dan pengalamanmu selama menyewa kos.
        </p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($rentals->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <p class="text-gray-600">
                Kamu belum memiliki riwayat sewa yang bisa diberi ulasan.
            </p>
        </div>
    @else

        @foreach($rentals as $rental)
            <div class="bg-white rounded-lg shadow p-6 mb-5">

                <h2 class="text-lg font-bold text-gray-800">
                    {{ $rental->kamar?->kos?->nama_kos ?? 'Nama kos tidak tersedia' }}
                </h2>

                <p class="text-gray-600 mt-1">
                    Kamar:
                    {{ $rental->kamar?->nama_kamar ?? $rental->kamar?->nomor_kamar ?? '-' }}
                </p>

                <p class="text-sm text-gray-500 mt-1">
                    Status sewa: {{ ucfirst($rental->status_sewa) }}
                </p>

                <hr class="my-4">

                @if($rental->reviews->isNotEmpty())

                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="font-semibold text-green-700">
                            Ulasan sudah diberikan
                        </p>

                        <p class="mt-2">
                            Rating:
                            <span class="text-yellow-500">
                                {{ str_repeat('★', $rental->reviews->first()->rating) }}
                            </span>
                        </p>

                        <p class="text-gray-700 mt-2">
                            {{ $rental->reviews->first()->komentar ?? 'Tidak ada komentar.' }}
                        </p>
                    </div>

                @else

                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="id_sewa" value="{{ $rental->id }}">

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">
                                Berikan Rating
                            </label>

                            <select name="rating"
                                class="w-full border rounded-lg p-2"
                                required>
                                <option value="">Pilih rating</option>
                                <option value="5">5 - Sangat Baik</option>
                                <option value="4">4 - Baik</option>
                                <option value="3">3 - Cukup</option>
                                <option value="2">2 - Kurang</option>
                                <option value="1">1 - Sangat Kurang</option>
                            </select>

                            @error('rating')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">
                                Komentar
                            </label>

                            <textarea name="komentar"
                                rows="3"
                                maxlength="1000"
                                class="w-full border rounded-lg p-3"
                                placeholder="Ceritakan pengalamanmu selama menyewa kos...">{{ old('komentar') }}</textarea>

                            @error('komentar')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        @error('id_sewa')
                            <p class="text-red-500 text-sm mb-3">{{ $message }}</p>
                        @enderror

                        <button type="submit"
                            class="bg-blue-900 hover:bg-blue-800 text-white px-5 py-2 rounded-lg">
                            Kirim Ulasan
                        </button>
                    </form>

                @endif

            </div>
        @endforeach

    @endif

</div>
@endsection
