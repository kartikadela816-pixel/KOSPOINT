@extends('layouts.app')

@section('title', 'Cari Kos — KOSPOINT')

@section('content')
<section class="bg-gradient-to-br from-emerald-50 via-white to-green-50">
    <div class="mx-auto max-w-6xl px-4 py-12">
        <p class="text-sm font-bold uppercase tracking-wider text-green-700">
            Temukan Hunianmu
        </p>

        <h1 class="mt-2 text-3xl font-extrabold text-slate-900 md:text-4xl">
            Cari Kos yang Sesuai Kebutuhanmu
        </h1>

        <p class="mt-3 max-w-2xl leading-7 text-slate-600">
            Temukan berbagai pilihan kos berdasarkan lokasi dan anggaran.
            Gunakan filter untuk mempersempit pilihanmu.
        </p>

        <form action="{{ route('cari-kos') }}" method="GET"
              class="mt-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-lg">

            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label for="q" class="mb-2 block text-sm font-semibold text-slate-700">
                        Nama kos atau lokasi
                    </label>
                    <input id="q" name="q" type="search"
                           value="{{ request('q') }}"
                           placeholder="Contoh: Banyuwangi, Rogojampi"
                           class="kp-input">
                </div>

                <div>
                    <label for="min_price" class="mb-2 block text-sm font-semibold text-slate-700">
                        Harga minimum per bulan
                    </label>
                    <input id="min_price" name="min_price" type="number"
                           min="0" value="{{ request('min_price') }}"
                           placeholder="Rp minimum" class="kp-input">
                </div>

                <div>
                    <label for="max_price" class="mb-2 block text-sm font-semibold text-slate-700">
                        Harga maksimum per bulan
                    </label>
                    <input id="max_price" name="max_price" type="number"
                           min="0" value="{{ request('max_price') }}"
                           placeholder="Rp maksimum" class="kp-input">
                </div>
            </div>

            <div class="mt-5 flex flex-wrap gap-3">
                <button type="submit" class="kp-tombol px-7 py-3">
                    Cari Kos
                </button>

                <a href="{{ route('cari-kos') }}"
                   class="kp-tombol-sekunder rounded-xl border border-slate-200 px-7 py-3">
                    Reset Filter
                </a>
            </div>
        </form>
    </div>
</section>

<section class="bg-slate-50 py-12">
    <div class="mx-auto max-w-6xl px-4">
        <div class="flex flex-wrap items-end justify-between gap-3">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900">
                    Hasil Pencarian
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    {{ $kos->count() }} kos ditemukan
                </p>
            </div>
        </div>

        @if ($kos->isEmpty())
            <div class="mt-8 rounded-2xl border border-dashed border-green-200 bg-white p-10 text-center">
                <h3 class="font-bold text-slate-800">
                    Kos belum ditemukan
                </h3>
                <p class="mt-2 text-sm text-slate-500">
                    Coba ubah kata kunci atau rentang harga pencarianmu.
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
                                       target="_blank" rel="noopener"
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
@endsection