<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KosPoint</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-blue-900 text-white p-4">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
        <a href="{{ route('beranda') }}" class="font-bold text-xl">
            KosPoint
        </a>

        <div class="flex gap-4 items-center">
            <a href="{{ route('beranda') }}">Beranda</a>
            <a href="#">Cari Kos</a>
            <a href="#">Tentang</a>

            @auth
                <span>{{ auth()->user()->name }}</span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="bg-red-500 px-3 py-1 rounded">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Registrasi</a>
            @endauth
        </div>
    </div>
</nav>

<section class="bg-blue-900 text-white py-16">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-bold mb-4">
            Temukan Kos yang Sesuai Kebutuhanmu
        </h1>

        <p class="mb-6">
            Cari kos berdasarkan lokasi, harga, jenis kos, dan fasilitas.
        </p>

        <form action="#" class="flex gap-2 max-w-xl mx-auto">
            <input type="text"
                   placeholder="Cari nama kos, alamat, atau wilayah..."
                   class="w-full p-3 rounded text-black">

            <button class="bg-yellow-400 text-black px-5 rounded font-semibold">
                Cari
            </button>
        </form>
    </div>
</section>

<section class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Kenapa Memakai KosPoint?</h2>

    <div class="grid md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded shadow">
            <h3 class="font-bold mb-2">Peta Interaktif</h3>
            <p>Lihat lokasi kos melalui marker pada peta.</p>
        </div>

        <div class="bg-white p-5 rounded shadow">
            <h3 class="font-bold mb-2">Informasi Kamar</h3>
            <p>Lihat harga, fasilitas, dan status ketersediaan kamar.</p>
        </div>

        <div class="bg-white p-5 rounded shadow">
            <h3 class="font-bold mb-2">Hubungi Pemilik</h3>
            <p>Hubungi pemilik kos melalui WhatsApp atau telepon.</p>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Kos Terbaru</h2>

    <p class="text-gray-600">
        Belum ada data kos. Data kos akan muncul setelah pemilik menambahkan kos.
    </p>
</section>

<footer class="bg-blue-900 text-white p-6 text-center mt-10">
    <p>&copy; 2026 KosPoint</p>
</footer>

</body>
</html>