@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">

    <div class="mb-8">
        <span class="text-blue-700 font-semibold text-sm">KOSPOINT</span>
        <h2 class="text-3xl font-bold text-gray-800 mt-2">
            Laporan dan Pengaduan
        </h2>
        <p class="text-gray-500 mt-2">
            Sampaikan kendala atau pengaduan terkait layanan kos.
        </p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded-xl mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-10">
        <h3 class="text-xl font-bold text-gray-800 mb-5">
            Kirim Laporan Baru
        </h3>

        <form action="{{ route('reports.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="judul" class="block text-gray-700 font-semibold mb-2">
                    Judul Laporan
                </label>
                <input
                    type="text"
                    name="judul"
                    id="judul"
                    value="{{ old('judul') }}"
                    placeholder="Masukkan judul laporan"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
            </div>

            <div class="mb-5">
                <label for="isi_laporan" class="block text-gray-700 font-semibold mb-2">
                    Isi Laporan
                </label>
                <textarea
                    name="isi_laporan"
                    id="isi_laporan"
                    rows="5"
                    placeholder="Ceritakan kendala atau pengaduan kamu..."
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >{{ old('isi_laporan') }}</textarea>
            </div>

            <button
                type="submit"
                class="bg-blue-800 hover:bg-blue-900 text-white font-semibold px-6 py-3 rounded-xl transition"
            >
                Kirim Laporan
            </button>
        </form>
    </div>

    <div>
        <h3 class="text-2xl font-bold text-gray-800 mb-5">
            Riwayat Laporan Saya
        </h3>

        @forelse ($reports as $report)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-4">

                <div class="flex justify-between items-start gap-3 mb-3">
                    <h4 class="text-lg font-bold text-gray-800">
                        {{ $report->judul }}
                    </h4>

                    @php
                        $statusClass = [
                            'menunggu' => 'bg-yellow-100 text-yellow-800',
                            'diproses' => 'bg-blue-100 text-blue-800',
                            'selesai' => 'bg-green-100 text-green-800',
                            'ditolak' => 'bg-red-100 text-red-800',
                        ][$report->status] ?? 'bg-gray-100 text-gray-700';
                    @endphp

                    <span class="text-xs font-bold px-3 py-2 rounded-full {{ $statusClass }}">
                        {{ ucfirst($report->status) }}
                    </span>
                </div>

                <p class="text-gray-600 mb-4">
                    {{ $report->isi_laporan }}
                </p>

                @if ($report->tanggapan)
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-4">
                        <p class="font-bold text-blue-900 mb-1">
                            Tanggapan Admin
                        </p>
                        <p class="text-gray-700">
                            {{ $report->tanggapan }}
                        </p>
                    </div>
                @endif

                <p class="text-sm text-gray-400">
                    {{ $report->created_at->format('d-m-Y H:i') }}
                </p>
            </div>
        @empty
            <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center">
                <p class="text-gray-500">
                    Belum ada laporan yang dikirim.
                </p>
            </div>
        @endforelse
    </div>
</div>
@endsection
