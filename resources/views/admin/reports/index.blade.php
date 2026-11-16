@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <div class="mb-8">
        <p class="text-sm font-semibold text-blue-700 mb-2">KOSPOINT • ADMIN</p>
        <h1 class="text-3xl font-bold text-gray-800">Kelola Laporan Pengguna</h1>
        <p class="text-gray-500 mt-2">
            Periksa laporan dari pengguna dan berikan tanggapan.
        </p>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="space-y-5">
        @forelse ($reports as $report)

            @php
                $statusClass = [
                    'menunggu' => 'bg-yellow-100 text-yellow-800',
                    'diproses' => 'bg-blue-100 text-blue-800',
                    'selesai' => 'bg-green-100 text-green-800',
                    'ditolak' => 'bg-red-100 text-red-800',
                ][$report->status] ?? 'bg-gray-100 text-gray-700';
            @endphp

            <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">

                <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">
                            {{ $report->judul }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Pelapor:
                            <span class="font-semibold text-gray-700">
                                {{ $report->pelapor->name ?? 'Pengguna tidak ditemukan' }}
                            </span>
                        </p>
                    </div>

                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                        {{ ucfirst($report->status) }}
                    </span>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 mb-4">
                    <p class="text-sm font-semibold text-gray-700 mb-2">
                        Isi Laporan
                    </p>
                    <p class="text-gray-600 leading-relaxed whitespace-pre-line">
                        {{ $report->isi_laporan }}
                    </p>
                </div>

                <p class="text-sm text-gray-400 mb-5">
                    Dikirim pada:
                    {{ $report->created_at->format('d-m-Y H:i') }}
                </p>

                <div class="border-t border-gray-100 pt-5">
                    <h3 class="font-semibold text-gray-800 mb-4">
                        Tindak Lanjut Laporan
                    </h3>

                    <form action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Status Laporan
                            </label>

                            <select
                                name="status"
                                required
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="menunggu" {{ $report->status == 'menunggu' ? 'selected' : '' }}>
                                    Menunggu
                                </option>
                                <option value="diproses" {{ $report->status == 'diproses' ? 'selected' : '' }}>
                                    Diproses
                                </option>
                                <option value="selesai" {{ $report->status == 'selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                                <option value="ditolak" {{ $report->status == 'ditolak' ? 'selected' : '' }}>
                                    Ditolak
                                </option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggapan Admin
                            </label>

                            <textarea
                                name="tanggapan"
                                rows="3"
                                placeholder="Tuliskan tanggapan untuk pengguna..."
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >{{ $report->tanggapan }}</textarea>
                        </div>

                        <button
                            type="submit"
                            class="rounded-xl bg-blue-800 px-5 py-3 font-semibold text-white hover:bg-blue-900 transition"
                        >
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

        @empty
            <div class="bg-white border border-gray-200 rounded-2xl p-10 text-center">
                <h3 class="text-lg font-semibold text-gray-700">
                    Belum Ada Laporan
                </h3>
                <p class="text-gray-500 mt-2">
                    Saat ini belum ada laporan dari pengguna.
                </p>
            </div>
        @endforelse
    </div>

</div>
@endsection
