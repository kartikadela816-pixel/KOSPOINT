@extends('layouts.app')

@section('title', 'Detail ' . $kos->nama_kos)

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">

    {{-- KEMBALI --}}
    <a href="{{ route('kos.index') }}"
       class="inline-flex items-center gap-2 text-sm font-bold text-brand-700 hover:text-brand-500">
        <span class="text-xl">&larr;</span>
        Kembali ke pencarian
    </a>

    {{-- HEADER --}}
    <section class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <span class="inline-block bg-brand-100 text-brand-800 px-4 py-1.5 rounded-full text-xs font-bold uppercase">
                {{ ucfirst($kos->jenis_kos) }}
            </span>

            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-3">
                {{ $kos->nama_kos }}
            </h1>

            <p class="text-gray-500 mt-2 flex gap-2">
                <span>📍</span>
                {{ $kos->alamat }}
            </p>
        </div>

        <span class="inline-block px-4 py-2 rounded-full text-sm font-bold
            {{ $kos->status_kos === 'aktif'
                ? 'bg-green-100 text-green-700'
                : 'bg-gray-100 text-gray-600' }}">
            {{ ucfirst($kos->status_kos) }}
        </span>
    </section>

    {{-- GALERI FOTO --}}
    <section>
        @php
            $fotoUtama = $kos->foto->first();
        @endphp

        @if ($fotoUtama)

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 rounded-2xl overflow-hidden">

                <div class="md:col-span-2">
                    @php
                        $gambarUtama = filter_var($fotoUtama->url_foto, FILTER_VALIDATE_URL)
                            ? $fotoUtama->url_foto
                            : asset('storage/' . $fotoUtama->url_foto);
                    @endphp

                    <img src="{{ $gambarUtama }}"
                         alt="Foto {{ $kos->nama_kos }}"
                         class="w-full h-72 md:h-96 object-cover">
                </div>

                <div class="grid grid-cols-2 md:grid-cols-1 gap-3">
                    @foreach ($kos->foto->skip(1)->take(2) as $foto)
                        @php
                            $gambar = filter_var($foto->url_foto, FILTER_VALIDATE_URL)
                                ? $foto->url_foto
                                : asset('storage/' . $foto->url_foto);
                        @endphp

                        <img src="{{ $gambar }}"
                             alt="Foto {{ $kos->nama_kos }}"
                             class="w-full h-40 md:h-[188px] object-cover">
                    @endforeach

                    @if ($kos->foto->count() === 1)
                        <div class="hidden md:flex bg-gray-100 items-center justify-center text-gray-400">
                            Foto tambahan belum tersedia
                        </div>
                    @endif
                </div>
            </div>

        @else
            <div class="h-72 bg-gray-100 rounded-2xl flex flex-col items-center justify-center text-gray-400">
                <span class="text-5xl mb-3">🏠</span>
                <p>Foto kos belum tersedia</p>
            </div>
        @endif
    </section>

    {{-- KONTEN --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <main class="lg:col-span-2 space-y-6">

            {{-- DESKRIPSI --}}
            <section class="bg-white rounded-2xl border border-gray-100 shadow-soft p-6">
                <h2 class="text-xl font-bold text-slate-900 mb-4">
                    Tentang Kos
                </h2>

                <p class="text-gray-600 leading-7 whitespace-pre-line">
                    {{ $kos->deskripsi ?: 'Deskripsi kos belum tersedia.' }}
                </p>
            </section>

            {{-- KAMAR --}}
            <section class="bg-white rounded-2xl border border-gray-100 shadow-soft p-6">

                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-xl font-bold text-slate-900">
                        Pilihan Kamar
                    </h2>

                    <span class="text-sm text-gray-500">
                        {{ $kos->kamar->count() }} kamar
                    </span>
                </div>

                <div class="space-y-4">

                    @forelse ($kos->kamar as $kamar)

                        <div class="border border-gray-200 rounded-xl p-5 hover:border-brand-300 transition">

                            <div class="flex flex-col sm:flex-row sm:justify-between gap-3">

                                <div>
                                    <h3 class="font-bold text-lg text-slate-900">
                                        {{ $kamar->nama_kamar ?: 'Kamar ' . $kamar->nomor_kamar }}
                                    </h3>

                                    <p class="text-sm text-gray-500 mt-1">
                                        🚿 Kamar mandi {{ $kamar->jenis_kamar_mandi ?: 'Belum diinformasikan' }}
                                    </p>
                                </div>

                                <span class="inline-block h-fit px-3 py-1 rounded-full text-xs font-bold
                                    {{ strtolower($kamar->status_kamar) === 'tersedia'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($kamar->status_kamar) }}
                                </span>

                            </div>

                            <div class="mt-4">
                                <p class="text-sm text-gray-500">
                                    Harga sewa per bulan
                                </p>

                                <p class="text-2xl font-extrabold text-brand-700 mt-1">
                                    Rp{{ number_format($kamar->harga_per_bulan, 0, ',', '.') }}
                                    <span class="text-sm font-normal text-gray-500">/ bulan</span>
                                </p>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-100">

                                <p class="text-sm font-bold text-slate-800 mb-3">
                                    Fasilitas Kamar
                                </p>

                                <div class="flex flex-wrap gap-2">

                                    @forelse ($kamar->fasilitas as $fasilitas)

                                        <span class="bg-brand-50 text-brand-800 px-3 py-1.5 rounded-lg text-sm">
                                            ✓ {{ $fasilitas->nama_fasilitas }}
                                        </span>

                                    @empty
                                        <span class="text-sm text-gray-400">
                                            Fasilitas belum ditambahkan.
                                        </span>
                                    @endforelse

                                </div>
                            </div>

                        </div>

                    @empty
                        <div class="text-center py-10 bg-gray-50 rounded-xl">
                            <p class="text-3xl mb-2">🛏️</p>
                            <p class="text-gray-500">Belum ada informasi kamar.</p>
                        </div>
                    @endforelse

                </div>
            </section>

            {{-- ATURAN --}}
            <section class="bg-white rounded-2xl border border-gray-100 shadow-soft p-6">
                <h2 class="text-xl font-bold text-slate-900 mb-4">
                    Aturan Kos
                </h2>

                <div class="bg-amber-50 rounded-xl p-4 text-gray-700 leading-7 whitespace-pre-line">
                    {{ $kos->aturan_kos ?: 'Aturan kos belum tersedia.' }}
                </div>
            </section>

        </main>

        {{-- SIDEBAR --}}
        <aside class="space-y-5">

            {{-- KONTAK --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-soft p-6">

                <h2 class="text-lg font-bold text-slate-900 mb-2">
                    Tertarik dengan kos ini?
                </h2>

                <p class="text-sm text-gray-500 mb-5">
                    Hubungi pemilik untuk mendapatkan informasi lebih lanjut.
                </p>

                @if ($kos->nomor_whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $kos->nomor_whatsapp) }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="block text-center bg-green-600 hover:bg-green-700 text-white font-bold p-3 rounded-xl transition">
                        Hubungi via WhatsApp
                    </a>
                @endif

                @if ($kos->nomor_telepon)
                    <div class="mt-4 p-3 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-500">Nomor telepon</p>
                        <p class="font-semibold text-gray-800 mt-1">
                            {{ $kos->nomor_telepon }}
                        </p>
                    </div>
                @endif

                @if (!$kos->nomor_whatsapp && !$kos->nomor_telepon)
                    <p class="text-sm text-gray-500 bg-gray-50 p-3 rounded-xl">
                        Kontak pemilik belum tersedia.
                    </p>
                @endif

            </div>

            {{-- LOKASI --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-soft p-6">

                <h2 class="text-lg font-bold text-slate-900 mb-3">
                    Lokasi Kos
                </h2>

                <p class="text-sm text-gray-500 leading-6 mb-4">
                    📍 {{ $kos->alamat }}
                </p>

                @if ($kos->latitude !== null && $kos->longitude !== null)

                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $kos->latitude }},{{ $kos->longitude }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="block text-center bg-brand-700 hover:bg-brand-800 text-white font-semibold p-3 rounded-xl transition">
                        Lihat Rute Google Maps
                    </a>

                @else
                    <p class="text-sm text-gray-400">
                        Koordinat lokasi belum tersedia.
                    </p>
                @endif

            </div>

            {{-- TIPS --}}
            <div class="bg-brand-50 rounded-2xl p-5 border border-brand-100">
                <h3 class="font-bold text-brand-900 mb-2">
                    Tips KOSPOINT
                </h3>

                <p class="text-sm text-brand-800 leading-6">
                    Pastikan kamu menanyakan ketersediaan kamar dan ketentuan pembayaran kepada pemilik sebelum menyewa kos.
                </p>
            </div>

        </aside>

    </div>
</div>
@endsection