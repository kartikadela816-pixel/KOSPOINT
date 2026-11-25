@extends('layouts.app')

@section('title', 'KOSPOINT — Temukan Kos')

@section('content')

{{-- HERO --}}
<section class="relative overflow-hidden bg-gradient-to-br from-emerald-50 via-white to-green-50">
    <div class="mx-auto max-w-6xl px-4 py-12 md:py-16">
        <div class="grid items-center gap-10 md:grid-cols-2">

            <div>
                <span class="inline-flex rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-800">
                    Temukan Hunian yang Tepat
                </span>

                <h1 class="mt-5 text-4xl font-extrabold leading-tight tracking-tight text-slate-900 md:text-5xl">
                    Temukan Kos Nyaman,
                    <span class="text-green-700">Tanpa Ribet.</span>
                </h1>

                <p class="mt-5 max-w-lg leading-7 text-slate-600">
                    Cari kos sesuai lokasi, kebutuhan, dan anggaranmu.
                    Temukan informasi kos dengan lebih mudah bersama KOSPOINT.
                </p>

<div class="mt-7">
    <a href="{{ route('tentang') }}"
       class="kp-tombol-sekunder inline-flex border border-green-200 bg-white px-6 py-3">
        Kenali KOSPOINT
    </a>
</div>

                <div class="mt-7 flex flex-wrap gap-6 text-sm text-slate-600">
                    <span>✓ Informasi jelas</span>
                    <span>✓ Harga transparan</span>
                    <span>✓ Mudah digunakan</span>
                </div>
            </div>

            <div class="rounded-3xl bg-green-100 p-6 md:p-8">
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        @include('partials.logo-mark', [
                            'ukuran' => 'h-12 w-12 rounded-xl',
                            'ikon' => 'h-7 w-7'
                        ])
                        <div>
                            <h2 class="text-xl font-extrabold text-slate-900">KOSPOINT</h2>
                            <p class="text-sm text-slate-500">Temukan kos lebih mudah</p>
                        </div>
                    </div>

                    <div class="mt-7 rounded-xl bg-green-50 p-5">
                        <p class="text-sm font-semibold text-green-800">Cari tempat tinggalmu</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">
                            Kos yang cocok dimulai dari sini.
                        </p>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-3">
                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">Pencarian</p>
                            <p class="mt-1 font-bold text-slate-900">Lebih mudah</p>
                        </div>
                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">Informasi</p>
                            <p class="mt-1 font-bold text-slate-900">Lebih jelas</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- SATU FORM PENCARIAN --}}
        <form id="cari-kos"
      action="{{ route('cari-kos') }}#daftar-kos"
      method="GET"
              class="mt-10 rounded-2xl border border-slate-200 bg-white p-4 shadow-lg">

            <div class="grid gap-3 md:grid-cols-4">

                <div class="md:col-span-2">
                    <label for="q" class="mb-2 block text-sm font-semibold text-slate-700">
                        Lokasi atau nama kos
                    </label>
                    <input id="q" name="q" type="search"
                           value="{{ request('q') }}"
                           placeholder="Contoh: Banyuwangi, Rogojampi..."
                           class="kp-input">
                </div>

                <div>
                    <label for="min_price" class="mb-2 block text-sm font-semibold text-slate-700">
                        Harga minimum
                    </label>
                    <input id="min_price" name="min_price" type="number"
                           min="0" value="{{ request('min_price') }}"
                           placeholder="Rp minimum"
                           class="kp-input">
                </div>

                <div>
                    <label for="max_price" class="mb-2 block text-sm font-semibold text-slate-700">
                        Harga maksimum
                    </label>
                    <input id="max_price" name="max_price" type="number"
                           min="0" value="{{ request('max_price') }}"
                           placeholder="Rp maksimum"
                           class="kp-input">
                </div>

            </div>

            <button type="submit" class="kp-tombol mt-4 w-full py-3">
                Cari Kos
            </button>
        </form>
    </div>
</section>


{{-- TENTANG KOSPOINT --}}
<section id="tentang" class="scroll-mt-24 bg-white py-16 md:py-20">
    <div class="mx-auto max-w-6xl px-4">

        <div class="grid items-center gap-10 md:grid-cols-2">
            <div>
                <p class="text-sm font-bold uppercase tracking-wider text-green-700">
                    Tentang KOSPOINT
                </p>

                <h2 class="mt-3 text-3xl font-extrabold leading-tight text-slate-900 md:text-4xl">
                    Satu Platform untuk Menemukan dan Mengelola Kos
                </h2>

                <p class="mt-5 leading-8 text-slate-600">
                    KOSPOINT merupakan platform informasi dan pengelolaan
                    kos yang dirancang untuk mempermudah pencari kos
                    mendapatkan hunian sesuai kebutuhan serta membantu
                    pemilik kos memperkenalkan dan mengelola properti mereka.
                </p>

                <p class="mt-4 leading-8 text-slate-600">
                    Melalui KOSPOINT, informasi mengenai lokasi, harga,
                    dan ketersediaan kamar dapat diakses dengan lebih praktis.
                    Pemilik juga dapat mengelola data kos dan kamar melalui
                    dashboard yang tersedia.
                </p>
            </div>

            <div class="rounded-3xl bg-gradient-to-br from-green-100 to-emerald-50 p-7 md:p-10">
                <div class="rounded-2xl bg-white p-7 shadow-sm">
                    <p class="text-sm font-bold text-green-700">
                        KOSPOINT
                    </p>
                    <h3 class="mt-3 text-2xl font-extrabold leading-snug text-slate-900">
                        Hunian yang tepat dimulai dari informasi yang jelas.
                    </h3>
                    <p class="mt-4 text-sm leading-7 text-slate-600">
                        Membantu pencari dan pemilik kos terhubung
                        melalui informasi yang lebih mudah diakses.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-16 text-center">
            <p class="text-sm font-bold uppercase tracking-wider text-green-700">
                Mengenal Lebih Dekat
            </p>
            <h2 class="mt-2 text-3xl font-extrabold text-slate-900">
                Apa yang Ingin Kami Hadirkan?
            </h2>
            <p class="mx-auto mt-3 max-w-2xl leading-7 text-slate-600">
                KOSPOINT hadir dengan tujuan memberikan pengalaman
                pencarian dan pengelolaan kos yang lebih praktis.
            </p>
        </div>

        <div class="mt-9 grid gap-5 md:grid-cols-3">
            <article class="kp-kartu p-6">
                <div class="kp-ikon mb-5">
                    <span class="text-xl">⌕</span>
                </div>
                <h3 class="font-bold text-slate-900">Pencarian Lebih Mudah</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">
                    Membantu pencari kos menemukan pilihan hunian
                    berdasarkan nama, lokasi, dan rentang harga.
                </p>
            </article>

            <article class="kp-kartu p-6">
                <div class="kp-ikon mb-5">
                    <span class="text-xl">⌂</span>
                </div>
                <h3 class="font-bold text-slate-900">Pengelolaan Terarah</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">
                    Memberikan kemudahan bagi pemilik dalam mengelola
                    informasi properti dan data kamar kos.
                </p>
            </article>

            <article class="kp-kartu p-6">
                <div class="kp-ikon mb-5">
                    <span class="text-xl">✓</span>
                </div>
                <h3 class="font-bold text-slate-900">Informasi Terorganisir</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600">
                    Menyajikan informasi kos, harga, dan ketersediaan
                    kamar agar lebih mudah dipahami.
                </p>
            </article>
        </div>

        <div class="mt-16 rounded-3xl bg-green-800 px-6 py-10 text-center text-white md:px-12">
            <h2 class="text-2xl font-extrabold md:text-3xl">
                Temukan Kos yang Tepat Bersama KOSPOINT
            </h2>
            <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-green-100">
                Mulai pencarianmu dan temukan informasi hunian
                yang sesuai dengan kebutuhanmu.
            </p>
            <a href="{{ route('cari-kos') }}"
               class="mt-6 inline-flex rounded-xl bg-white px-6 py-3 font-bold text-green-800 hover:bg-green-50">
                Mulai Cari Kos
            </a>
        </div>

    </div>
</section>


{{-- KOS TERBARU --}}
<section id="daftar-kos" class="bg-slate-50 py-14">
    <div class="mx-auto max-w-6xl px-4">

        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-bold uppercase tracking-wider text-green-700">
                    Pilihan Hunian
                </p>

                <h2 class="mt-2 text-3xl font-extrabold text-slate-900">
                    {{ $halamanCari ? 'Hasil Pencarian Kos' : 'Kos Terbaru' }}
                </h2>

                <p class="mt-2 text-sm text-slate-600">
                    Temukan kos yang sesuai dengan kebutuhanmu.
                </p>
            </div>

            @if (!$halamanCari)
                <a href="{{ route('cari-kos') }}"
                   class="font-semibold text-green-700 hover:text-green-800">
                    Lihat semua kos →
                </a>
            @endif
        </div>

        @if ($kos->isEmpty())

            <div class="mt-8 rounded-2xl border border-dashed border-green-200 bg-white p-10 text-center">
                <h3 class="font-bold text-slate-800">
                    {{ request('q') ? 'Kos tidak ditemukan' : 'Belum ada data kos' }}
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    Coba gunakan kata kunci atau rentang harga yang berbeda.
                </p>
            </div>

        @else

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($kos as $item)

                    <article class="kp-kartu flex flex-col overflow-hidden transition hover:-translate-y-1 hover:shadow-lg">

                        <div class="flex h-40 items-center justify-center bg-gradient-to-br from-green-100 to-emerald-50">
                            <div class="text-center">
                                <span class="text-5xl">⌂</span>
                                <p class="mt-2 text-sm font-semibold text-green-800">
                                    KOSPOINT
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-1 flex-col p-5">

                            <div class="flex items-start justify-between gap-2">
                                <h3 class="font-bold text-slate-900">
                                    {{ $item->nama_kos }}
                                </h3>

                                <span class="kp-lencana capitalize">
                                    {{ $item->jenis_kos }}
                                </span>
                            </div>

                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                {{ $item->alamat }}
                            </p>

                            <div class="mt-5">
                                <p class="text-xs text-slate-500">Harga mulai dari</p>

                                <p class="mt-1 text-xl font-extrabold text-green-700">
                                    {{ $item->harga_mulai !== null
                                        ? 'Rp '.number_format($item->harga_mulai, 0, ',', '.')
                                        : '-' }}

                                    <span class="text-xs font-medium text-slate-500">
                                        / bulan
                                    </span>
                                </p>
                            </div>

                            <div class="mt-auto flex items-center justify-between border-t border-slate-100 pt-4">
                                <span class="text-xs text-slate-500">
                                    {{ $item->kamar_tersedia_count }} kamar tersedia
                                </span>

                                @if ($item->nomor_whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $item->nomor_whatsapp)) }}"
                                       target="_blank"
                                       rel="noopener"
                                       class="text-sm font-bold text-green-700 hover:text-green-800">
                                        Hubungi Pemilik →
                                    </a>
                                @endif
                            </div>

                        </div>
                    </article>

                @endforeach

            </div>

        @endif
    </div>
</section>


{{-- AJAKAN PEMILIK --}}
@guest
<section class="mx-auto max-w-6xl px-4 py-14">
    <div class="rounded-3xl bg-green-800 px-6 py-10 text-center text-white md:px-12">
        <h2 class="text-2xl font-extrabold md:text-3xl">
            Punya Properti Kos?
        </h2>

        <p class="mx-auto mt-3 max-w-xl text-sm leading-6 text-green-100">
            Daftarkan kosmu di KOSPOINT dan kelola informasi properti
            dengan lebih praktis.
        </p>

<a href="{{ route('register', ['role' => 'pemilik']) }}"
   class="mt-6 inline-flex rounded-xl bg-white px-6 py-3 font-bold text-green-800 hover:bg-green-50">
    Daftar sebagai Pemilik
</a>
    </div>
</section>
@endguest


{{-- FOOTER --}}
<footer class="bg-slate-900 text-white">
    <div class="mx-auto grid max-w-6xl gap-8 px-4 py-10 md:grid-cols-3">

        <div>
            <h2 class="text-xl font-extrabold">KOSPOINT</h2>
            <p class="mt-3 max-w-xs text-sm leading-6 text-slate-400">
                Marketplace informasi kos berbasis lokasi.
                Praktis, aman, dan transparan.
            </p>
        </div>

        <div>
            <h3 class="font-bold">Navigasi</h3>
            <div class="mt-3 flex flex-col gap-2 text-sm text-slate-400">
                <a href="{{ route('beranda') }}" class="hover:text-white">Beranda</a>
                <a href="{{ route('cari-kos') }}" class="hover:text-white">Cari Kos</a>
                <a href="{{ route('tentang') }}" class="hover:text-white">Tentang</a>
            </div>
        </div>

        <div>
            <h3 class="font-bold">Akun</h3>
            <div class="mt-3 flex flex-col gap-2 text-sm text-slate-400">
                <a href="{{ route('login') }}" class="hover:text-white">Masuk</a>
                <a href="{{ route('register') }}" class="hover:text-white">Daftar</a>
            </div>
        </div>

    </div>

    <div class="border-t border-slate-700 px-4 py-5 text-center text-xs text-slate-400">
        © {{ date('Y') }} KOSPOINT. All rights reserved.
    </div>
</footer>

@endsection