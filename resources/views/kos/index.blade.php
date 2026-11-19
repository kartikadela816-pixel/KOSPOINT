@extends('layouts.app')

@section('title', 'Cari Kos')

@section('content')

<div class="mx-auto max-w-7xl px-5 py-10 lg:px-8">

    {{-- HEADER --}}
    <div class="mb-8">
        <p class="text-sm font-bold text-brand-600">
            KOSPOINT / PENCARIAN
        </p>

        <h1 class="mt-2 text-3xl font-extrabold text-slate-900">
            Temukan Kos Impianmu
        </h1>

        <p class="mt-2 text-slate-500">
            Cari kos nyaman sesuai lokasi, harga, dan fasilitas.
        </p>
    </div>

    {{-- FORM PENCARIAN --}}
    <form action="{{ route('kos.index') }}"
          method="GET"
          class="rounded-2xl border border-emerald-100 bg-white p-5 shadow-soft">

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">

            <div>
                <label class="mb-2 block text-sm font-semibold">
                    Nama atau alamat kos
                </label>

                <input type="text"
                       name="q"
                       value="{{ request('q') }}"
                       placeholder="Cari nama atau alamat..."
                       class="w-full rounded-xl border border-slate-200 p-3 focus:border-brand-500 focus:outline-none">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">
                    Jenis kos
                </label>

                <select name="jenis"
                        class="w-full rounded-xl border border-slate-200 p-3">

                    <option value="">Semua jenis</option>

                    <option value="putra"
                        {{ request('jenis') == 'putra' ? 'selected' : '' }}>
                        Putra
                    </option>

                    <option value="putri"
                        {{ request('jenis') == 'putri' ? 'selected' : '' }}>
                        Putri
                    </option>

                    <option value="campur"
                        {{ request('jenis') == 'campur' ? 'selected' : '' }}>
                        Campur
                    </option>

                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">
                    Fasilitas
                </label>

                <select name="fasilitas"
                        class="w-full rounded-xl border border-slate-200 p-3">

                    <option value="">Semua fasilitas</option>

                    @foreach($daftarFasilitas as $fasilitas)
                        <option value="{{ $fasilitas->nama_fasilitas }}"
                            {{ request('fasilitas') == $fasilitas->nama_fasilitas ? 'selected' : '' }}>
                            {{ $fasilitas->nama_fasilitas }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">
                    Harga minimum
                </label>

                <input type="number"
                       name="harga_min"
                       value="{{ request('harga_min') }}"
                       placeholder="Contoh: 500000"
                       min="0"
                       class="w-full rounded-xl border border-slate-200 p-3">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">
                    Harga maksimum
                </label>

                <input type="number"
                       name="harga_max"
                       value="{{ request('harga_max') }}"
                       placeholder="Contoh: 1500000"
                       min="0"
                       class="w-full rounded-xl border border-slate-200 p-3">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold">
                    Urutkan berdasarkan
                </label>

                <select name="sort"
                        class="w-full rounded-xl border border-slate-200 p-3">

                    <option value="">Terbaru</option>

                    <option value="harga_termurah"
                        {{ request('sort') == 'harga_termurah' ? 'selected' : '' }}>
                        Harga termurah
                    </option>

                    <option value="harga_termahal"
                        {{ request('sort') == 'harga_termahal' ? 'selected' : '' }}>
                        Harga termahal
                    </option>

                </select>
            </div>

        </div>

        <div class="mt-5 flex flex-wrap gap-3">

            <button type="submit"
                    class="rounded-xl bg-brand-600 px-6 py-3 font-bold text-white hover:bg-brand-700">
                Cari Kos
            </button>

            <a href="{{ route('kos.index') }}"
               class="rounded-xl border border-slate-200 px-6 py-3 font-semibold text-slate-600 hover:bg-slate-50">
                Reset Filter
            </a>

        </div>

    </form>


    {{-- HASIL PENCARIAN --}}
    <div class="mb-5 mt-10 flex items-center justify-between">

        <div>
            <h2 class="text-xl font-extrabold text-slate-900">
                Daftar Kos
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ $kos->total() }} kos ditemukan
            </p>
        </div>

    </div>


    {{-- KARTU KOS --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

        @forelse($kos as $item)

            <article class="overflow-hidden rounded-2xl border border-emerald-100 bg-white shadow-soft transition hover:-translate-y-1 hover:shadow-lg">

                {{-- FOTO KOS --}}
                @php
                    $foto = $item->foto->first();
                @endphp

                @if($foto && $foto->url_foto)
                    <img src="{{ $foto->url_foto }}"
                         alt="{{ $item->nama_kos }}"
                         class="h-52 w-full object-cover">
                @else
                    <div class="flex h-52 items-center justify-center bg-brand-50 text-brand-600">
                        <span class="text-sm font-semibold">
                            Foto kos belum tersedia
                        </span>
                    </div>
                @endif


                <div class="p-5">

                    {{-- JENIS KOS --}}
                    <span class="rounded-full bg-brand-50 px-3 py-1 text-xs font-bold capitalize text-brand-700">
                        {{ ucfirst($item->tipe_kos) }}
                    </span>

                    {{-- NAMA --}}
                    <h3 class="mt-3 text-lg font-extrabold text-slate-900">
                        {{ $item->nama_kos }}
                    </h3>

                    {{-- ALAMAT --}}
                    <p class="mt-2 text-sm text-slate-500">
                        {{ $item->alamat }}
                    </p>

                    {{-- DESKRIPSI --}}
                    <p class="mt-3 text-sm leading-6 text-slate-600">
                        {{ \Illuminate\Support\Str::limit($item->deskripsi, 100) }}
                    </p>

                    {{-- HARGA --}}
                    <div class="mt-4 border-t border-slate-100 pt-4">

                        <p class="text-xs text-slate-500">
                            Harga mulai dari
                        </p>

                        <p class="mt-1 text-xl font-extrabold text-brand-700">

                            @if($item->kamar_min_harga !== null)
                                Rp{{ number_format($item->kamar_kos_min_harga_per_bulan, 0, ',', '.') }}
                                <span class="text-xs font-medium text-slate-500">
                                    / bulan
                                </span>
                            @else
                                Belum tersedia
                            @endif

                        </p>

                    </div>

                    {{-- DETAIL --}}
                    <a href="{{ route('kos.show', $item->id) }}"
                       class="mt-5 block rounded-xl bg-brand-600 px-4 py-3 text-center text-sm font-bold text-white transition hover:bg-brand-700">
                        Lihat Detail Kos
                    </a>

                </div>

            </article>

        @empty

            <div class="col-span-full rounded-2xl border border-dashed border-emerald-200 bg-white p-12 text-center">

                <h3 class="text-lg font-bold text-slate-800">
                    Kos belum ditemukan
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    Coba ubah kata kunci atau filter pencarianmu.
                </p>

            </div>

        @endforelse

    </div>


    {{-- PAGINATION --}}
    <div class="mt-8">
        {{ $kos->links() }}
    </div>

</div>

@endsection
