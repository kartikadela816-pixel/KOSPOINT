@extends('layouts.app')

@section('title', 'Peta Lokasi Kos - KOSPOINT')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Judul halaman -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">
            Peta Lokasi Kos
        </h1>

        <p class="text-gray-600 mt-2">
            Temukan lokasi kos dan lihat rute menuju kos pilihanmu.
        </p>
    </div>

    <!-- Informasi peta -->
    <div class="bg-white rounded-xl shadow-sm border p-4 mb-5">
        <div class="flex items-center gap-3">
            <div class="bg-blue-100 p-3 rounded-lg">
                <span class="text-2xl">📍</span>
            </div>

            <div>
                <h2 class="font-semibold text-gray-800">
                    Lokasi Kos KOSPOINT
                </h2>

                <p class="text-sm text-gray-500">
                    Klik penanda pada peta untuk melihat informasi kos.
                </p>
            </div>
        </div>
    </div>

    <!-- Peta -->
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <div id="map" style="height: 500px; width: 100%;"></div>
    </div>

    <!-- Keterangan -->
    <div class="mt-4 text-sm text-gray-500">
        <p>
            💡 Pilih salah satu penanda lokasi untuk melihat detail kos
            dan membuka petunjuk arah Google Maps.
        </p>
    </div>

    <!-- Pesan status -->
    <div id="map-status"
         class="mt-3 text-sm text-gray-600">
        Sedang memuat lokasi kos...
    </div>

</div>

@endsection


@push('styles')
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>
@endpush


@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Membuat peta
    const map = L.map('map').setView([-8.2192, 114.3691], 10);

    // Menggunakan OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const status = document.getElementById('map-status');

    // Mengambil data lokasi kos dari Laravel
    fetch(@json(route('peta.locations')))
        .then(response => {
            if (!response.ok) {
                throw new Error('Gagal mengambil data lokasi kos.');
            }

            return response.json();
        })
        .then(result => {

            // Mendukung format array maupun object data
            const kosList = Array.isArray(result)
                ? result
                : (result.data || result.kos || []);

            const bounds = [];

            kosList.forEach(kos => {

                const lat = parseFloat(
                    kos.latitude ?? kos.lat ?? kos.latitude_kos
                );

                const lng = parseFloat(
                    kos.longitude ?? kos.lng ?? kos.longitude_kos
                );

                // Lewati data yang belum memiliki koordinat
                if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
                    return;
                }

                const nama = kos.nama_kos ?? kos.name ?? 'Kos';
                const alamat = kos.alamat ?? 'Alamat belum tersedia';

                const marker = L.marker([lat, lng]).addTo(map);

                const googleMapsUrl =
                    'https://www.google.com/maps/dir/?api=1&destination='
                    + encodeURIComponent(lat + ',' + lng);

                marker.bindPopup(`
                    <div style="min-width:180px">
                        <h3 style="font-weight:bold;margin-bottom:6px">
                            ${escapeHtml(nama)}
                        </h3>

                        <p style="margin-bottom:10px">
                            ${escapeHtml(alamat)}
                        </p>

                        <a href="${googleMapsUrl}"
                           target="_blank"
                           rel="noopener noreferrer"
                           style="color:#2563eb;font-weight:bold">
                            Lihat Rute Google Maps →
                        </a>
                    </div>
                `);

                bounds.push([lat, lng]);
            });

            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [40, 40] });

                status.textContent =
                    'Berhasil menampilkan ' + bounds.length +
                    ' lokasi kos pada peta.';
            } else {
                status.textContent =
                    'Belum ada data kos dengan koordinat yang tersedia.';
            }

        })
        .catch(error => {
            console.error(error);

            status.textContent =
                'Gagal memuat lokasi kos. Periksa MapController dan API lokasi.';
        });

    function escapeHtml(value) {
        return String(value).replace(/[&<>"']/g, function (char) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char];
        });
    }

});
</script>
@endpush
