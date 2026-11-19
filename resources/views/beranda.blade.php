
@extends('layouts.app')

@section('title', 'KOSPOINT - Find Your Comfort')

@section('content')

<header class="navbar">
    <a href="/" class="logo">
        <span class="logo-icon">K</span>
        KOS<span>POINT</span>
    </a>

    <nav class="nav-menu">
        <a href="/" class="active">Beranda</a>
        <a href="#cari">Cari Kos</a>
        <a href="#rekomendasi">Rekomendasi</a>
        <a href="#tentang">Tentang Kami</a>
    </nav>

    <div class="nav-actions">
        <a href="/login" class="login-btn">Masuk</a>
        <a href="/register" class="register-btn">Daftar</a>
    </div>
</header>

<main>

<section class="hero">
    <div class="hero-content">
        <span class="hero-label">TEMUKAN HUNIAN IMPIANMU</span>

        <h1>
            Temukan Kos Nyaman,
            <span>Mulai Cerita Barumu.</span>
        </h1>

        <p>
            Cari tempat tinggal yang nyaman, aman, dan sesuai
            kebutuhanmu. Semua pilihan kos ada di KOSPOINT.
        </p>

        <a href="#cari" class="hero-button">
            Temukan Kos Sekarang →
        </a>

        <div class="hero-stat">
            <div>
                <strong>100+</strong>
                <small>Pilihan Kos</small>
            </div>
            <div>
                <strong>50+</strong>
                <small>Pemilik Kos</small>
            </div>
            <div>
                <strong>4.8/5</strong>
                <small>Rating Pengguna</small>
            </div>
        </div>
    </div>

    <div class="hero-image">
        <img
            src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=1000"
            alt="Interior hunian nyaman">
        <div class="image-tag">
            <span>✦</span>
            Temukan Hunian Nyaman
        </div>
    </div>
</section>

<section class="search-section" id="cari">
    <div class="section-heading">
        <span class="eyebrow">PENCARIAN KOS</span>
        <h2>Mau Cari Kos di Mana?</h2>
        <p>Temukan kos yang sesuai dengan kebutuhanmu.</p>
    </div>

    <form action="{{ route('kos.index') }}" method="GET" class="search-box">

        <div class="search-field">
            <label>Lokasi</label>
            <input type="text" name="lokasi"
                placeholder="Masukkan nama daerah atau kampus">
        </div>

        <div class="search-field">
            <label>Harga Maksimal</label>
            <select name="harga">
                <option value="">Semua harga</option>
                <option value="500000">Di bawah Rp500 ribu</option>
                <option value="1000000">Di bawah Rp1 juta</option>
                <option value="2000000">Di bawah Rp2 juta</option>
            </select>
        </div>

        <div class="search-field">
            <label>Tipe Kos</label>
            <select name="tipe">
                <option value="">Semua tipe</option>
                <option value="Putra">Kos Putra</option>
                <option value="Putri">Kos Putri</option>
                <option value="Campur">Kos Campur</option>
            </select>
        </div>

        <button type="submit" class="search-button">
            🔍 Cari Kos
        </button>
    </form>
</section>

<section class="category-section">
    <div class="section-heading">
        <span class="eyebrow">KATEGORI</span>
        <h2>Temukan Kos Sesuai Kebutuhan</h2>
    </div>

    <div class="category-grid">
        <a href="{{ route('kos.index', ['tipe'=>'Putra']) }}" class="category-card">
            <div class="category-icon">👨</div>
            <h3>Kos Putra</h3>
            <p>Hunian khusus pria</p>
        </a>

        <a href="{{ route('kos.index', ['tipe'=>'Putri']) }}" class="category-card">
            <div class="category-icon">👩</div>
            <h3>Kos Putri</h3>
            <p>Hunian khusus wanita</p>
        </a>

        <a href="{{ route('kos.index', ['tipe'=>'Campur']) }}" class="category-card">
            <div class="category-icon">🏠</div>
            <h3>Kos Campur</h3>
            <p>Hunian bersama</p>
        </a>

        <a href="#rekomendasi" class="category-card">
            <div class="category-icon">⭐</div>
            <h3>Kos Favorit</h3>
            <p>Pilihan terbaik</p>
        </a>
    </div>
</section>

<section class="property-section" id="rekomendasi">
    <div class="section-heading heading-row">
        <div>
            <span class="eyebrow">PILIHAN TERBAIK</span>
            <h2>Rekomendasi Kos</h2>
            <p>Beberapa pilihan hunian untukmu.</p>
        </div>

        <a href="{{ route('kos.index') }}" class="see-all">
            Lihat Semua →
        </a>
    </div>

    <div class="property-grid">
        @foreach([
            [
                'nama'=>'Kos Melati Residence',
                'lokasi'=>'Banyuwangi',
                'harga'=>'650.000',
                'tipe'=>'Putri',
                'gambar'=>'photo-1522708323590-d24dbb6b0267'
            ],
            [
                'nama'=>'Kos Harmoni',
                'lokasi'=>'Banyuwangi',
                'harga'=>'850.000',
                'tipe'=>'Putra',
                'gambar'=>'photo-1505693416388-ac5ce068fe85'
            ],
            [
                'nama'=>'Kos Green House',
                'lokasi'=>'Banyuwangi',
                'harga'=>'1.000.000',
                'tipe'=>'Campur',
                'gambar'=>'photo-1493809842364-78817add7ffb'
            ]
        ] as $kos)
        <article class="property-card">
            <div class="property-image">
                <img
                    src="https://images.unsplash.com/{{ $kos['gambar'] }}?w=700"
                    alt="{{ $kos['nama'] }}">
                <span class="property-type">{{ $kos['tipe'] }}</span>
            </div>

            <div class="property-info">
                <span class="property-location">📍 {{ $kos['lokasi'] }}</span>
                <h3>{{ $kos['nama'] }}</h3>

                <div class="property-bottom">
                    <p>
                        <strong>Rp{{ $kos['harga'] }}</strong>
                        <small>/ bulan</small>
                    </p>
                    <span>★ 4.8</span>
                </div>

                <a href="{{ route('kos.index') }}" class="detail-button">
                    Lihat Detail
                </a>
            </div>
        </article>
        @endforeach
    </div>
</section>

<section class="cta-section" id="tentang">
    <div>
        <span class="eyebrow">BERSAMA KOSPOINT</span>
        <h2>Temukan Hunian yang Membuatmu Nyaman.</h2>
        <p>
            Mulai perjalananmu menemukan tempat tinggal
            yang tepat bersama KOSPOINT.
        </p>
    </div>

    <a href="#cari" class="cta-button">Cari Kos Sekarang →</a>
</section>

</main>

<footer class="footer">
    <a href="/" class="logo footer-logo">
        <span class="logo-icon">K</span>
        KOS<span>POINT</span>
    </a>

    <p>© {{ date('Y') }} KOSPOINT. Find Your Comfort, Find Your Home.</p>
</footer>

@endsection
