<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Koleksi</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: #f5f5f5;
        }

        /* ================= NAVBAR ================= */

        .navbar {
            position: sticky;
            top: 0;
            z-index: 999;
            background: #fff;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #222;
        }

        .logo img {
            width: 50px;
        }

        .menu {
            display: flex;
            gap: 50px;
        }

        .menu a {
            text-decoration: none;
            color: #222;
            font-weight: 600;
        }

        .menu a.active {
            color: #0F8248;
        }

        .user {
            font-weight: 600;
        }

        /* ================= CONTAINER ================= */

        .container {
            width: 95%;
            max-width: 1800px;
            margin: auto;
            padding: 40px 20px;
        }

        .back-link {
            text-decoration: none;
            color: #999;
            font-weight: 600;
        }

        .page-title {
            font-size: 64px;
            font-weight: 800;
            color: #444;
            margin-top: 20px;
        }

        .page-subtitle {
            color: #888;
            margin-top: 10px;
            margin-bottom: 40px;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .btn-submit:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        /* ================= KATALOG ================= */

        .catalog-box {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 25px;
            padding: 25px;
        }

        .search-wrapper {
            display: grid;
            grid-template-columns: 220px 1fr 180px;
            gap: 15px;
            margin-bottom: 25px;
        }

        .search-wrapper select,
        .search-wrapper input {
            height: 60px;
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 0 20px;
            font-size: 16px;
        }

        .btn-search {
            background: #0F8248;
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-search:hover {
            opacity: .9;
        }

        /* ================= GRID ================= */

        .koleksi-grid {
            display: grid;

            grid-template-columns:
                repeat(5, 1fr);

            gap: 20px;

            margin-top: 25px;
        }

        .koleksi-card {
            background: #fff;

            border: 1px solid #e5e7eb;

            border-radius: 14px;

            overflow: hidden;

            transition: .25s;
        }

        .koleksi-card:hover {
            transform: translateY(-5px);

            box-shadow:
                0 10px 25px rgba(0, 0, 0, .08);
        }

        .koleksi-card img {
            width: 100%;
            height: 320px;
            object-fit: contain;
            background: #f5f5f5;
            padding: 8px;
        }

        .koleksi-card.selected {
            border: 3px solid #0F8248;
            box-shadow: 0 0 0 3px rgba(15, 130, 72, .15);
            transform: translateY(-3px);
        }

        .koleksi-card.selected::after {
            content: "✓ Dipilih";
            position: absolute;
            top: 10px;
            right: 10px;

            background: #0F8248;
            color: white;

            padding: 6px 10px;
            border-radius: 8px;

            font-size: 12px;
            font-weight: 700;
        }

        .koleksi-card {
            position: relative;
        }

        .koleksi-body {
            padding: 12px;
        }

        .koleksi-penulis {
            color: #777;
            font-size: 13px;
        }

        .koleksi-judul {
            margin-top: 5px;
            font-size: 18px;
            font-weight: 700;
        }

        /* ================= PAGINATION ================= */

        .pagination-custom {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 35px;
        }

        .page-btn {
            width: 45px;
            height: 45px;

            display: flex;
            justify-content: center;
            align-items: center;

            text-decoration: none;

            border: 1px solid #dcdcdc;
            border-radius: 10px;

            background: white;
            color: #333;

            font-weight: 600;

            transition: .2s;
        }

        .page-btn:hover {
            background: #0F8248;
            color: white;
            border-color: #0F8248;
        }

        .page-btn.active {
            background: #0F8248;
            color: white;
            border-color: #0F8248;
        }

        .page-btn.disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        /* ================= DAFTAR PINJAMAN ================= */

        .pinjam-box {
            margin-top: 35px;
            background: #000;
            border-radius: 20px;
            padding: 30px;
        }

        .pinjam-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .pinjam-header h2 {
            color: white;
            font-size: 42px;
        }

        .counter {
            background: #222;
            color: white;
            padding: 8px 18px;
            border-radius: 20px;
        }

        .pinjam-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .pinjam-item {
            background: #1b1b26;
            border-radius: 15px;
            padding: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pinjam-left {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .pinjam-cover {
            width: 70px;
            height: 95px;

            object-fit: cover;

            border-radius: 6px;

            border: 1px solid #2b2b3d;

            flex-shrink: 0;
        }

        .pinjam-info strong {
            color: white;
            display: block;
            font-size: 22px;
            margin-bottom: 6px;
        }

        .pinjam-info small {
            color: #c8c8c8;
        }

        .btn-remove {
            background: none;
            border: none;
            color: white;
            font-size: 30px;
            cursor: pointer;
        }

        .empty-text {
            text-align: center;
            color: #999;
            padding: 20px;
        }

        .btn-submit {
            width: 70%;
            height: 60px;
            display: block;
            margin: 30px auto 0;
            border: none;
            border-radius: 10px;
            background: #0F8248;
            color: white;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
        }

        /* ================= FOOTER ================= */

        footer {
            background: #0F8248;
            color: white;
            text-align: center;
            padding: 30px;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <nav class="navbar">

        <a href="/" class="logo">
            <img src="{{ asset('images/logo.png') }}">
            <h2>SIMPER</h2>
        </a>

        <div class="menu">
            <a href="/">Katalog</a>
            <a href="/anggota/peminjaman" class="active">Peminjaman</a>
            <a href="/">Tentang Kami</a>
            <a href="/">Panduan</a>
        </div>

        <div class="user">
            👋 Halo, {{ session('nama_lengkap') }}
        </div>

    </nav>

    <div class="container">

        <a href="{{ route('anggota.peminjaman') }}" class="back-link">
            ← Kembali ke Halaman Sebelumnya
        </a>

        <h1 class="page-title">
            Buat Peminjaman Baru
        </h1>

        <p class="page-subtitle">
            Pilih koleksi yang ingin dipinjam
        </p>

        @if(session('error'))

            <div class="alert-error">
                {{ session('error') }}
            </div>

        @endif

        @if(session('success'))

            <div class="alert-success">
                {{ session('success') }}
            </div>

        @endif

        @if($errors->any())

            <div class="alert-error">

                <ul style="margin:0;padding-left:20px;">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <div class="catalog-box">

            <form action="{{ route('anggota.peminjaman.create') }}" method="GET" class="search-wrapper">

                <select name="jenis">

                    <option value="semua">
                        Semua Katalog
                    </option>

                    @foreach($jenisKoleksi as $jenis)

                        <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>
                            {{ $jenis }}
                        </option>

                    @endforeach

                </select>

                <input type="text" name="search" placeholder="Masukkan kata kunci pencarian"
                    value="{{ request('search') }}">

                <button type="submit" class="btn-search">
                    Cari Koleksi
                </button>

            </form>

            <div class="koleksi-grid">

                @foreach($koleksis as $koleksi)

                            <div id="card-{{ $koleksi->id_koleksi }}" class="koleksi-card"
                                onclick="tambahKoleksi(
                                                                                                                                                                                                                                                    {{ $koleksi->id_koleksi }},
                                                                                                                                                                                                                                                    '{{ addslashes($koleksi->judul_koleksi) }}',
                                                                                                                                                                                                                                                    '{{ addslashes($koleksi->penulis) }}',
                                                                                                                                                                                                                                                    '{{ $koleksi->gambar
                    ? asset('uploads/koleksi/' . $koleksi->gambar)
                    : asset('images/no-cover.png')
                                                                                                                                                                                                                                                    }}'
                                                                                                                                                                                                                                                )">

                                @if($koleksi->gambar)

                                    <img src="{{ asset('uploads/koleksi/' . $koleksi->gambar) }}" alt="{{ $koleksi->judul_koleksi }}">

                                @else

                                    <img src="{{ asset('images/no-cover.png') }}" alt="No Cover">

                                @endif

                                <div class="koleksi-body">

                                    <div class="koleksi-penulis">
                                        {{ $koleksi->penulis }}
                                    </div>

                                    <div class="koleksi-judul">
                                        {{ $koleksi->judul_koleksi }}
                                    </div>

                                </div>

                            </div>

                @endforeach

            </div>

        </div>

        <div class="pagination-custom">

            @if($koleksis->onFirstPage())

                <span class="page-btn disabled">
                    ‹
                </span>

            @else

                <a href="{{ $koleksis->previousPageUrl() }}" class="page-btn">

                    ‹

                </a>

            @endif

            @for(
                    $i = 1;
                    $i <= $koleksis->lastPage();
                    $i++
                )

                <a href="{{ $koleksis->url($i) }}"
                    class="page-btn
                                                                                                                                                                {{ $koleksis->currentPage() == $i ? 'active' : '' }}">

                    {{ $i }}

                </a>

            @endfor

            @if($koleksis->hasMorePages())

                <a href="{{ $koleksis->nextPageUrl() }}" class="page-btn">

                    ›

                </a>

            @else

                <span class="page-btn disabled">
                    ›
                </span>

            @endif

        </div>

    </div>

    <form action="{{ route('anggota.peminjaman.store') }}" method="POST" onsubmit="return validasiPinjaman()">

        @csrf

        <div class="pinjam-box">

            <div class="pinjam-header">

                <h2>
                    📚 Daftar Pinjaman
                </h2>

                <div id="counter" class="counter">

                    0 / 3

                </div>

            </div>

            <div id="daftarPinjaman" class="pinjam-list">

                <div class="empty-text">

                    Belum ada koleksi dipilih

                </div>

            </div>

            <button type="submit" id="btnSubmit" class="btn-submit" disabled>

                Proses Peminjaman →

            </button>

        </div>

    </form>

    </div>

    <footer>

        <h3>
            Perpustakaan MTs Islamiyah Banat
        </h3>

        <br>

        Sistem Informasi Perpustakaan -
        Jl. K. Djoned No.62 Jatisari
        Senori Tuban Jawa Timur

    </footer>

    <script>
        let selectedBooks = [];

        /*
        |--------------------------------------------------------------------------
        | TAMBAH KOLEKSI
        |--------------------------------------------------------------------------
        */

        function tambahKoleksi(id, judul, penulis, gambar) {
            if (selectedBooks.length >= 3) {
                alert('Maksimal 3 koleksi');
                return;
            }

            if (
                selectedBooks.some(
                    item => item.id == id
                )
            ) {
                return;
            }

            selectedBooks.push({
                id: id,
                judul: judul,
                penulis: penulis,
                gambar: gambar
            });

            let card =
                document.getElementById(
                    'card-' + id
                );

            if (card) {
                card.classList.add(
                    'selected'
                );
            }

            renderPinjaman();
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS KOLEKSI
        |--------------------------------------------------------------------------
        */

        function hapusKoleksi(id) {
            selectedBooks =
                selectedBooks.filter(
                    item => item.id != id
                );

            let card =
                document.getElementById(
                    'card-' + id
                );

            if (card) {
                card.classList.remove(
                    'selected'
                );
            }

            renderPinjaman();
        }

        /*
        |--------------------------------------------------------------------------
        | RENDER DAFTAR PINJAMAN
        |--------------------------------------------------------------------------
        */

        function renderPinjaman() {
            const daftar =
                document.getElementById(
                    'daftarPinjaman'
                );

            const counter =
                document.getElementById(
                    'counter'
                );

            const btnSubmit =
                document.getElementById(
                    'btnSubmit'
                );

            counter.innerText =
                selectedBooks.length + ' / 3';

            btnSubmit.disabled =
                selectedBooks.length === 0;

            /*
            |--------------------------------------------------------------------------
            | KOSONG
            |--------------------------------------------------------------------------
            */

            if (selectedBooks.length === 0) {
                daftar.innerHTML = `
            <div class="empty-text">
                Belum ada koleksi dipilih
            </div>
        `;

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | ADA DATA
            |--------------------------------------------------------------------------
            */

            let html = '';

            selectedBooks.forEach(item => {

                html += `

            <div class="pinjam-item">

                <div class="pinjam-left">

                    <img
    src="${item.gambar}"
    class="pinjam-cover"
>

                    <div class="pinjam-info">

                        <strong>
                            ${item.judul}
                        </strong>

                        <small>
                            ${item.penulis}
                        </small>

                    </div>

                </div>

                <button
                    type="button"
                    class="btn-remove"
                    onclick="hapusKoleksi(${item.id})">

                    ×

                </button>

                <input
                    type="hidden"
                    name="koleksi[]"
                    value="${item.id}">

            </div>

        `;
            });

            daftar.innerHTML = html;
        }

        /*
        |--------------------------------------------------------------------------
        | LOAD AWAL
        |--------------------------------------------------------------------------
        */

        renderPinjaman();
    </script>

    <script>
        function validasiPinjaman() {
            if (selectedBooks.length === 0) {
                alert(
                    'Pilih minimal 1 koleksi.'
                );

                return false;
            }

            if (selectedBooks.length > 3) {
                alert(
                    'Maksimal 3 koleksi.'
                );

                return false;
            }

            return true;
        }
    </script>
</body>

</html>