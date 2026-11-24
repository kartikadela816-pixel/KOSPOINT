@extends('layouts.app')

@section('title', 'KOSPOINT - Temukan Kos Impianmu')

@section('content')

<style>
    .home-page {
        color: #183b2b;
        overflow: hidden;
    }

    .home-page * {
        box-sizing: border-box;
    }

    .home-container {
        width: min(1160px, 92%);
        margin: auto;
    }

    .home-hero {
        padding: 75px 0 85px;
        background: linear-gradient(120deg, #f0f9f3 0%, #ffffff 65%);
    }

    .hero-grid {
        display: grid;
        grid-template-columns: 1.05fr .95fr;
        align-items: center;
        gap: 55px;
    }

    .hero-label {
        display: inline-block;
        padding: 9px 16px;
        border-radius: 30px;
        background: #dcfce7;
        color: #15803d;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1px;
        margin-bottom: 22px;
    }

    .hero-title {
        font-size: clamp(38px, 5vw, 58px);
        line-height: 1.13;
        font-weight: 800;
        letter-spacing: -2px;
        color: #173d2b;
        margin: 0 0 22px;
    }

    .hero-title span {
        color: #16a05a;
    }

    .hero-description {
        color: #64756a;
        font-size: 16px;
        line-height: 1.9;
        max-width: 490px;
        margin-bottom: 30px;
    }

    .hero-button {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #16834b;
        color: white !important;
        padding: 15px 25px;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s;
    }

    .hero-button:hover {
        background: #11683b;
        transform: translateY(-2px);
    }

    .hero-image-wrap {
        position: relative;
        padding: 12px;
        background: white;
        border-radius: 28px;
        box-shadow: 0 22px 55px rgba(24, 70, 43, .13);
    }

    .hero-image {
        width: 100%;
        height: 390px;
        object-fit: cover;
        border-radius: 20px;
        display: block;
    }

    .hero-image-label {
        position: absolute;
        left: -25px;
        bottom: 35px;
        background: white;
        padding: 15px 20px;
        border-radius: 14px;
        box-shadow: 0 8px 25px rgba(0,0,0,.10);
        font-weight: 700;
        color: #24583b;
    }

    .hero-image-label small {
        display: block;
        color: #829087;
        font-weight: 400;
        margin-top: 4px;
    }

    .home-stats {
        display: flex;
        gap: 35px;
        margin-top: 42px;
        flex-wrap: wrap;
    }

    .stat-item strong {
        display: block;
        font-size: 25px;
        color: #16834b;
    }

    .stat-item span {
        color: #819087;
        font-size: 13px;
    }

    .home-section {
        padding: 75px 0;
    }

    .section-heading {
        text-align: center;
        margin-bottom: 35px;
    }

    .section-eyebrow {
        color: #16834b;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1.5px;
    }

    .section-heading h2 {
        color: #183b2b;
        font-size: clamp(26px, 3vw, 36px);
        font-weight: 800;
        margin: 10px 0;
    }

    .section-heading p {
        color: #7a8980;
        font-size: 15px;
    }

    .search-section {
        position: relative;
        z-index: 2;
        margin-top: -25px;
    }

    .search-card {
        background: white;
        padding: 28px;
        border-radius: 20px;
        box-shadow: 0 12px 40px rgba(20, 60, 35, .10);
        border: 1px solid #edf3ee;
    }

    .search-form {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr auto;
        align-items: end;
        gap: 16px;
    }

    .search-field label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 9px;
        color: #345442;
    }

    .search-field input,
    .search-field select {
        width: 100%;
        height: 48px;
        padding: 0 14px;
        border: 1px solid #dfe9e1;
        border-radius: 10px;
        background: #fbfdfb;
        color: #40574a;
        outline: none;
    }

    .search-field input:focus,
    .search-field select:focus {
        border-color: #16834b;
        box-shadow: 0 0 0 3px rgba(22, 131, 75, .10);
    }

    .search-submit {
        height: 48px;
        border: none;
        border-radius: 10px;
        padding: 0 24px;
        background: #16834b;
        color: white;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
    }

    .search-submit:hover {
        background: #11683b;
    }

    .category-section {
        background: #ffffff;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .category-card {
        display: block;
        text-align: center;
        padding: 30px 18px;
        border: 1px solid #e8f0e9;
        border-radius: 17px;
        background: white;
        text-decoration: none;
        transition: .25s;
    }

    .category-card:hover {
        transform: translateY(-6px);
        border-color: #9bd8b1;
        box-shadow: 0 12px 30px rgba(20, 90, 45, .09);
    }

    .category-icon {
        width: 62px;
        height: 62px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        border-radius: 18px;
        background: #e9f8ee;
        color: #16834b;
        font-size: 25px;
        font-weight: 800;
    }

    .category-card h3 {
        font-size: 17px;
        font-weight: 800;
        color: #244a34;
        margin-bottom: 7px;
    }

    .category-card p {
        font-size: 13px;
        color: #829087;
        margin: 0;
    }

    .benefit-section {
        background: #f5faf6;
    }

    .benefit-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
    }

    .benefit-card {
        background: white;
        padding: 28px;
        border-radius: 16px;
        border: 1px solid #eaf1eb;
    }

    .benefit-number {
        color: #16834b;
        font-size: 13px;
        font-weight: 800;
        margin-bottom: 15px;
    }

    .benefit-card h3 {
        color: #244a34;
        font-size: 18px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .benefit-card p {
        color: #7b8980;
        line-height: 1.8;
        font-size: 14px;
        margin: 0;
    }

    .home-cta {
        padding: 65px 30px;
        border-radius: 22px;
        background: linear-gradient(120deg, #146b3c, #239b5b);
        color: white;
        text-align: center;
    }

    .home-cta h2 {
        font-size: clamp(25px, 3vw, 35px);
        font-weight: 800;
        margin-bottom: 12px;
    }

    .home-cta p {
        color: #e1f5e8;
        margin-bottom: 25px;
    }

    .cta-button {
        display: inline-block;
        background: white;
        color: #167343 !important;
        padding: 14px 25px;
        border-radius: 10px;
        font-weight: 800;
        text-decoration: none;
        transition: .2s;
    }

    .cta-button:hover {
        background: #eaf8ee;
        transform: translateY(-2px);
    }

    @media (max-width: 850px) {
        .hero-grid {
            grid-template-columns: 1fr;
            gap: 35px;
        }

        .hero-image-wrap {
            max-width: 600px;
            margin: auto;
        }

        .search-form {
            grid-template-columns: 1fr 1fr;
        }

        .category-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .benefit-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 520px) {
        .home-hero {
            padding: 45px 0 65px;
        }

        .hero-title {
            letter-spacing: -1px;
        }

        .hero-image {
            height: 260px;
        }

        .hero-image-label {
            left: 10px;
            bottom: 20px;
        }

        .home-stats {
            gap: 20px;
        }

        .search-form {
            grid-template-columns: 1fr;
        }

        .category-grid {
            gap: 12px;
        }

        .category-card {
            padding: 22px 10px;
        }

        .home-section {
            padding: 55px 0;
        }
    }
</style>

<div class="home-page">

    {{-- HERO --}}
    <section class="home-hero">
        <div class="home-container hero-grid">

            <div>
                <span class="hero-label">SELAMAT DATANG DI KOSPOINT</span>

                <h1 class="hero-title">
                    Temukan Kos Nyaman,
                    <span>Mulai Cerita Barumu.</span>
                </h1>

                <p class="hero-description">
                    Bingung mencari tempat tinggal yang nyaman?
                    KOSPOINT membantu kamu menemukan kos yang sesuai
                    dengan kebutuhan, lokasi, dan anggaranmu.
                </p>

                <a href="#cari-kos" class="hero-button">
                    Mulai Cari Kos <span aria-hidden="true">&rarr;</span>
                </a>

                <div class="home-stats">
                    <div class="stat-item">
                        <strong>Praktis</strong>
                        <span>Pencarian lebih mudah</span>
                    </div>

                    <div class="stat-item">
                        <strong>Fleksibel</strong>
                        <span>Pilihan sesuai kebutuhan</span>
                    </div>

                    <div class="stat-item">
                        <strong>Terarah</strong>
                        <span>Informasi lokasi kos</span>
                    </div>
                </div>
            </div>

            <div class="hero-image-wrap">
                <img
                    class="hero-image"
                    src="https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=1000"
                    alt="Interior hunian nyaman">

                <div class="hero-image-label">
                    Hunian Nyaman Dimulai di Sini
                    <small>Temukan tempat tinggal pilihanmu</small>
                </div>
            </div>

        </div>
    </section>

    {{-- PENCARIAN --}}
    <section class="home-container search-section" id="cari-kos">
        <div class="search-card">

            <div class="section-heading">
                <span class="section-eyebrow">PENCARIAN KOS</span>
                <h2>Mulai Temukan Kos Pilihanmu</h2>
                <p>Masukkan lokasi dan tipe kos yang kamu inginkan.</p>
            </div>

            <form action="{{ route('kos.index') }}" method="GET" class="search-form">

                <div class="search-field">
                    <label for="home-lokasi">Lokasi atau Nama Kos</label>
                    <input
                        type="text"
                        id="home-lokasi"
                        name="q"
                        placeholder="Contoh: dekat kampus, Banyuwangi">
                </div>

                <div class="search-field">
                    <label for="home-harga">Harga Maksimal</label>
                    <select id="home-harga" name="harga">
                        <option value="">Semua harga</option>
                        <option value="500000">Di bawah Rp500 ribu</option>
                        <option value="1000000">Di bawah Rp1 juta</option>
                        <option value="2000000">Di bawah Rp2 juta</option>
                    </select>
                </div>

                <div class="search-field">
                    <label for="home-jenis">Tipe Kos</label>
                    <select id="home-jenis" name="jenis">
                        <option value="">Semua tipe</option>
                        <option value="Putra">Kos Putra</option>
                        <option value="Putri">Kos Putri</option>
                        <option value="Campur">Kos Campur</option>
                    </select>
                </div>

                <button type="submit" class="search-submit">
                    Cari Kos
                </button>

            </form>
        </div>
    </section>

    {{-- KATEGORI --}}
    <section class="home-section category-section">
        <div class="home-container">

            <div class="section-heading">
                <span class="section-eyebrow">KATEGORI HUNIAN</span>
                <h2>Pilih Kos Sesuai Kebutuhan</h2>
                <p>Temukan tipe hunian yang paling cocok untukmu.</p>
            </div>

            <div class="category-grid">

                <a href="{{ route('kos.index', ['jenis' => 'Putra']) }}" class="category-card">
                    <div class="category-icon">P</div>
                    <h3>Kos Putra</h3>
                    <p>Hunian khusus pria</p>
                </a>

                <a href="{{ route('kos.index', ['jenis' => 'Putri']) }}" class="category-card">
                    <div class="category-icon">W</div>
                    <h3>Kos Putri</h3>
                    <p>Hunian khusus wanita</p>
                </a>

                <a href="{{ route('kos.index', ['jenis' => 'Campur']) }}" class="category-card">
                    <div class="category-icon">K</div>
                    <h3>Kos Campur</h3>
                    <p>Lihat semua kos campur</p>
                </a>

                <a href="{{ route('kos.index') }}" class="category-card">
                    <div class="category-icon">+</div>
                    <h3>Semua Kos</h3>
                    <p>Lihat seluruh pilihan kos</p>
                </a>

            </div>
        </div>
    </section>

    {{-- KEUNGGULAN --}}
    <section class="home-section benefit-section">
        <div class="home-container">

            <div class="section-heading">
                <span class="section-eyebrow">KENAPA KOSPOINT?</span>
                <h2>Cari Kos Jadi Lebih Mudah</h2>
                <p>Kami membantu proses pencarian tempat tinggal menjadi lebih praktis.</p>
            </div>

            <div class="benefit-grid">

                <div class="benefit-card">
                    <div class="benefit-number">01 / PENCARIAN</div>
                    <h3>Pencarian Lebih Praktis</h3>
                    <p>
                        Cari kos berdasarkan lokasi, tipe hunian,
                        dan kisaran harga sesuai kebutuhanmu.
                    </p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-number">02 / INFORMASI</div>
                    <h3>Informasi Lebih Lengkap</h3>
                    <p>
                        Lihat informasi kos, foto, fasilitas,
                        serta detail hunian sebelum memilih.
                    </p>
                </div>

                <div class="benefit-card">
                    <div class="benefit-number">03 / LOKASI</div>
                    <h3>Lokasi Lebih Mudah Ditemukan</h3>
                    <p>
                        Manfaatkan fitur peta untuk membantu
                        menemukan lokasi kos yang kamu cari.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="home-section">
        <div class="home-container">
            <div class="home-cta">
                <h2>Sudah Siap Menemukan Kos Impianmu?</h2>
                <p>
                    Mulai pencarianmu sekarang dan temukan hunian
                    yang sesuai dengan kebutuhanmu.
                </p>

                <a href="{{ route('kos.index') }}" class="cta-button">
                    Jelajahi Semua Kos &rarr;
                </a>
            </div>
        </div>
    </section>

</div>

@endsection
