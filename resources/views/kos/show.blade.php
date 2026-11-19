
@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <a href="{{ route('kos.index') }}"
       class="text-blue-800 hover:underline">
        &larr; Kembali ke pencarian
    </a>

    <div>
        <h1 class="text-3xl font-bold text-blue-900">
            {{ $kos->nama_kos }}
        </h1>
        <p class="text-gray-600 mt-2">{{ $kos->alamat }}</p>
        <span class="inline-block mt-2 bg-blue-100 text-blue-800 px-3 py-1 rounded">
            {{ ucfirst($kos->jenis_kos) }}
        </span>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        @forelse ($kos->fotoKos as $foto)
            @php
                $gambar = filter_var($foto->url_foto, FILTER_VALIDATE_URL)
                    ? $foto->url_foto
                    : asset('storage/' . $foto->url_foto);
            @endphp

            <img src="{{ $gambar }}"
                 alt="Foto {{ $kos->nama_kos }}"
                 class="w-full h-64 object-cover rounded-xl">
        @empty
            <div class="bg-gray-200 rounded-xl h-64 flex items-center justify-center text-gray-500">
                Belum ada foto kos
            </div>
        @endforelse
    </div>

    <div class="grid md:grid-cols-3 gap-6">

        <div class="md:col-span-2 space-y-6">

            <section class="bg-white rounded-xl shadow p-5">
                <h2 class="text-xl font-bold mb-3">Deskripsi Kos</h2>
                <p class="text-gray-700 whitespace-pre-line">
                    {{ $kos->deskripsi ?: 'Belum ada deskripsi kos.' }}
                </p>
            </section>

            <section class="bg-white rounded-xl shadow p-5">
                <h2 class="text-xl font-bold mb-4">Informasi Kamar</h2>

                <div class="space-y-4">
                    @forelse ($kos->kamarKos as $kamar)
                        <div class="border rounded-lg p-4">
                            <h3 class="font-bold">
                                {{ $kamar->nama_kamar ?: 'Kamar ' . $kamar->nomor_kamar }}
                            </h3>

                            <p class="text-blue-900 font-bold mt-2">
                                Rp{{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}/bulan
                            </p>

                            <p class="text-sm text-gray-600 mt-1">
                                Kamar mandi {{ $kamar->jenis_kamar_mandi }}
                            </p>

                            <p class="text-sm mt-1">
                                Status: {{ ucfirst($kamar->status_kamar) }}
                            </p>

                            <div class="mt-3">
                                <p class="font-semibold text-sm">Fasilitas kamar:</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @forelse ($kamar->facilities as $fasilitas)
                                        <span class="bg-gray-100 px-3 py-1 rounded-full text-sm">
                                            {{ $fasilitas->nama_fasilitas }}
                                        </span>
                                    @empty
                                        <span class="text-sm text-gray-500">
                                            Belum ada fasilitas.
                                        </span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada informasi kamar.</p>
                    @endforelse
                </div>
            </section>

            <section class="bg-white rounded-xl shadow p-5">
                <h2 class="text-xl font-bold mb-3">Aturan Kos</h2>
                <p class="text-gray-700 whitespace-pre-line">
                    {{ $kos->aturan_kos ?: 'Belum ada aturan kos.' }}
                </p>
            </section>

        </div>

        <aside class="space-y-4">

            <div class="bg-white rounded-xl shadow p-5">
                <h2 class="font-bold text-lg mb-3">Hubungi Pemilik</h2>

                @if ($kos->nomor_whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $kos->nomor_whatsapp) }}"
                       target="_blank"
                       class="block text-center bg-green-600 text-white p-3 rounded-lg mb-3">
                        Hubungi WhatsApp
                    </a>
                @endif

                @if ($kos->nomor_telepon)
                    <p class="text-sm text-gray-600">
                        Telepon: {{ $kos->nomor_telepon }}
                    </p>
                @endif

                @if (!$kos->nomor_whatsapp && !$kos->nomor_telepon)
                    <p class="text-sm text-gray-500">
                        Kontak pemilik belum tersedia.
                    </p>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow p-5">
                <h2 class="font-bold text-lg mb-3">Lokasi Kos</h2>
                <p class="text-sm text-gray-600 mb-3">{{ $kos->alamat }}</p>

                @if ($kos->latitude && $kos->longitude)
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $kos->latitude }},{{ $kos->longitude }}"
                       target="_blank"
                       class="block text-center bg-blue-900 text-white p-3 rounded-lg">
                        Lihat Rute Google Maps
                    </a>
                @else
                    <p class="text-sm text-gray-500">
                        Koordinat lokasi belum tersedia.
                    </p>
                @endif
            </div>

        </aside>
    </div>
</div>
@endsection
