<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>SIMPER</title>

    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    <style>
    body {

        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .hero,
    .hero * {

        box-sizing: border-box;

    }

    body {
        padding-top: -20px;
    }

    /* ======================
           HERO
        ====================== */

    .hero {
        background: #0F8248;
        min-height: 650px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 60px;
    }

    .hero-left {
        width: 50%;
        color: white;
    }

    .hero-left h1 {
        font-size: 60px;
        margin-bottom: 15px;
    }

    .hero-left h2 {
        font-size: 40px;
        margin-bottom: 20px;
    }

    .hero-left p {
        font-size: 22px;
        line-height: 1.6;
    }

    .hero-right {
        width: 40%;
        text-align: center;
    }

    .hero-right img {
        width: 100%;
        max-width: 550px;
        margin-right: -130px;
    }

    /* ======================
           STATISTIK
        ====================== */

    .statistik {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .stat-box {
        background: white;
        text-align: center;
        padding: 35px;
        border: 1px solid #ddd;
    }

    .stat-box h1 {
        font-size: 60px;
        color: #4b5563;
    }

    .stat-box p {
        margin-top: 10px;
        letter-spacing: 3px;
        font-weight: bold;
        color: #444;
    }

    /* ======================
   BUKU TERPOPULER
====================== */

    .popular-section {
        width: 95%;
        margin: 70px auto;
    }

    .popular-header {
        margin-bottom: 30px;
    }

    .popular-header h2 {
        font-size: 40px;
        color: #374151;
        margin-bottom: 10px;
    }

    .popular-header p {
        color: #6b7280;
    }

    .popular-grid {

        display: grid;

        grid-template-columns: repeat(4, 1fr);

        gap: 25px;

    }

    /* ======================
           KATALOG
        ====================== */

    .section-title {
        text-align: center;
        font-size: 64px;
        color: #4b5563;
        margin: 60px 0 40px;
    }

    .katalog-wrapper {
        width: 95%;
        margin: auto;
        background: white;
        border-radius: 25px;
        padding: 25px;
        border: 1px solid #ddd;
    }

    .search-box {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
    }

    .search-box select {
        width: 220px;
        height: 60px;
        border: 1px solid #dcdcdc;
        border-radius: 15px;
        padding: 0 15px;
        font-size: 16px;
        background: #fff;
        cursor: pointer;
    }

    .search-box input {
        flex: 1;
        height: 60px;
        border: 1px solid #dcdcdc;
        border-radius: 15px;
        padding: 0 20px;
        font-size: 16px;
    }

    .search-box button {
        width: 220px;
        border: none;
        border-radius: 15px;
        background: #14893f;
        color: white;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
    }

    .search-box button:hover {
        background: #0f6e32;
    }

    .kategori {
        width: 180px;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background: white;
    }

    .search {
        flex: 1;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    .btn-search {
        width: 180px;
        border: none;
        border-radius: 10px;
        background: #15803d;
        color: white;
        font-weight: bold;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 24px;
        margin-top: 25px;
    }

    .koleksi-card {
        background: #f8f8f8;
        border-radius: 12px;
        overflow: hidden;
        transition: .25s;
        border: 1px solid #ececec;
    }

    .koleksi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
    }

    .koleksi-card img {
        width: 100%;
        height: 350px;
        object-fit: contain;
        background: white;
        display: block;
    }

    .card-body {
        padding: 12px;
    }

    .card-body small {
        color: #666;
        display: block;
        margin-bottom: 6px;
    }

    .card-body h4 {
        font-size: 20px;
        margin: 0;
    }

    .penulis {
        color: #777;
        font-size: 13px;
        margin-top: 10px;
    }

    .judul {
        margin-top: 5px;
        font-weight: bold;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 40px;
    }

    .pagination a,
    .pagination span {
        width: 42px;
        height: 42px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        border: 1px solid #ddd;
        border-radius: 8px;
        color: #333;
        font-weight: bold;
    }

    .pagination a:hover {
        background: #15803d;
        color: white;
    }

    .pagination .active {
        background: #15803d;
        color: white;
        border-color: #15803d;
    }

    .pagination .disabled {
        opacity: .4;
    }

    /* ======================
           FOOTER
        ====================== */

    footer {
        background: #15803d;
        color: white;
        text-align: center;
        padding: 30px;
        margin-top: 50px;
    }

    footer h3 {
        margin-bottom: 10px;
    }

    .logout-link:hover {
        background: #b91c1c;
    }

    .koleksi-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .empty-data {
        grid-column: 1/-1;
        text-align: center;
        padding: 70px 20px;
    }

    .empty-data img {
        width: 120px;
        opacity: .7;
        margin-bottom: 15px;
    }

    .empty-data h3 {
        color: #444;
        font-size: 28px;
        margin-bottom: 10px;
    }

    .empty-data p {
        color: #777;
        font-size: 16px;
    }
    </style>

</head>

<body>

    <!-- NAVBAR -->

    @include('components.navbar')
    <!-- HERO -->

    <section id="home" class="hero">

        <div class="hero-left">

            <h1>Selamat Datang di SIMPER</h1>

            <h2>MTs ISLAMIYAH BANAT SENORI</h2>

            <p>
                Temukan koleksi yang kalian inginkan
                dan lakukan peminjaman secara
                cepat di SIMPER.
            </p>

        </div>

        <div class="hero-right">

            <img src="{{ asset('images/hero-perpustakaan.png') }}" alt="Perpustakaan">

        </div>

    </section>

    <!-- STATISTIK -->

    <div class="statistik">

        <div class="stat-box">

            <h1>{{ $totalKoleksi }}</h1>

            <p>Total Koleksi</p>

        </div>

        <div class="stat-box">

            <h1>{{ $totalAnggota }}</h1>

            <p>Anggota Aktif</p>

        </div>

    </div>

    <!-- ======================
     BUKU TERPOPULER
====================== -->

    <section class="popular-section">

        <div class="popular-header">
            <h2>Buku Terpopuler</h2>
            <p>Koleksi yang paling sering dipinjam.</p>
        </div>

        <div class="popular-grid">

            @foreach($bukuPopuler as $koleksi)

            <a href="{{ route('koleksi.detail', $koleksi->id_koleksi) }}" class="koleksi-card-link">

                <div class="koleksi-card">

                    @if($koleksi->gambar)

                    <img src="{{ asset('uploads/koleksi/' . $koleksi->gambar) }}">

                    @else

                    <img src="{{ asset('images/no-cover.png') }}">

                    @endif

                    <div class="card-body">

                        <small>
                            {{ $koleksi->kategori->jenis->nama_jenis }}
                        </small>

                        <h4>

                            {{ $koleksi->judul_koleksi }}

                        </h4>

                        <div class="penulis">

                            {{ $koleksi->penulis }}

                        </div>

                        <div class="penulis">

                            Dipinjam
                            <b>{{ $koleksi->total_pinjam }}</b>
                            kali

                        </div>

                    </div>

                </div>

            </a>

            @endforeach

        </div>

    </section>

    <!-- ======================
     BUKU TERBARU
====================== -->

    <section class="popular-section">

        <div class="popular-header">
            <h2>Buku Terbaru</h2>
            <p>Koleksi yang baru ditambahkan ke perpustakaan.</p>
        </div>

        <div class="popular-grid">

            @foreach($bukuTerbaru as $koleksi)

            <a href="{{ route('koleksi.detail', $koleksi->id_koleksi) }}" class="koleksi-card-link">

                <div class="koleksi-card">

                    @if($koleksi->gambar)

                    <img src="{{ asset('uploads/koleksi/' . $koleksi->gambar) }}">

                    @else

                    <img src="{{ asset('images/no-cover.png') }}">

                    @endif

                    <div class="card-body">

                        <small>

                            {{ $koleksi->kategori->jenis->nama_jenis }}

                        </small>

                        <h4>

                            {{ $koleksi->judul_koleksi }}

                        </h4>

                        <div class="penulis">

                            {{ $koleksi->penulis }}

                        </div>

                        <div class="penulis">

                            Ditambahkan
                            {{ $koleksi->created_at->diffForHumans() }}

                        </div>

                    </div>

                </div>

            </a>

            @endforeach

        </div>

    </section>

    <!-- KATALOG -->

    <section id="katalog">

        <h1 class="section-title">
            Katalog
        </h1>

        <div class="katalog-wrapper">

            <form method="GET" action="/#katalog" class="search-box">

                <input type="hidden" name="scroll" value="katalog">

                <!-- DROPDOWN -->

                <select name="jenis">

                    <option value="Semua">
                        Semua Katalog
                    </option>

                    @foreach($jenisKoleksi as $jenis)

                    <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>
                        {{ $jenis }}
                    </option>

                    @endforeach

                </select>

                <!-- INPUT SEARCH -->

                <input type="text" name="keyword" placeholder="Masukkan kata kunci pencarian"
                    value="{{ request('keyword') }}">

                <button type="submit">
                    Cari Koleksi
                </button>

            </form>

            <div class="grid">

                @if($koleksis->isEmpty())

                <div class="empty-data">
                    <h3>Data koleksi tidak ditemukan</h3>
                    <p>Silakan gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
                </div>

                @else

                @foreach($koleksis as $koleksi)

                <a href="{{ route('koleksi.detail', $koleksi->id_koleksi) }}" class="koleksi-card-link">

                    <div class="koleksi-card">

                        @if($koleksi->gambar)
                        <img src="{{ asset('uploads/koleksi/' . $koleksi->gambar) }}"
                            alt="{{ $koleksi->judul_koleksi }}">
                        @else
                        <img src="{{ asset('images/no-cover.png') }}" alt="No Cover">
                        @endif

                        <div class="card-body">
                            <small>{{ $koleksi->penulis }}</small>
                            <h4>{{ $koleksi->judul_koleksi }}</h4>
                        </div>

                    </div>

                </a>

                @endforeach

                @endif

            </div>

            <div class="pagination">

                @if($koleksis->onFirstPage())
                <span class="disabled">‹</span>
                @else
                <a href="{{ $koleksis->previousPageUrl() }}">‹</a>
                @endif

                @for($i = 1; $i <= $koleksis->lastPage(); $i++)

                    <a href="{{ $koleksis->url($i) }}" class="{{ $i == $koleksis->currentPage() ? 'active' : '' }}">
                        {{ $i }}
                    </a>

                    @endfor

                    @if($koleksis->hasMorePages())
                    <a href="{{ $koleksis->nextPageUrl() }}">›</a>
                    @else
                    <span class="disabled">›</span>
                    @endif

            </div>

        </div>
    </section>


    <footer>

        <h3>
            Perpustakaan MTs Islamiyah Banat
        </h3>

        <p>
            Sistem Informasi Perpustakaan
            - Jl. K. Djoned No. 62 Jatisari
            Senori Tuban Jawa Timur
        </p>

    </footer>

    <script>
    const sections =
        document.querySelectorAll("section");

    const navLinks =
        document.querySelectorAll(".landing-link");

    window.addEventListener("scroll", () => {

        let current = "";

        sections.forEach(section => {

            const sectionTop = section.offsetTop - 120;

            if (window.scrollY >= sectionTop) {
                current = section.getAttribute("id");
            }

        });

        navLinks.forEach(link => {

            link.classList.remove("active");

            const href = link.getAttribute("href");

            if (current !== "" && href.endsWith("#" + current)) {
                link.classList.add("active");
            }

        });

    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {

        const url = new URL(window.location.href);

        if (url.searchParams.has("keyword") ||
            url.searchParams.has("jenis")) {

            const katalog = document.getElementById("katalog");

            if (katalog) {
                katalog.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        }

    });
    </script>
</body>

</html>