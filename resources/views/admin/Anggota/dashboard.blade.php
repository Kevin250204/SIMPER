<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Anggota</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f4f6f8;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: white;
            padding: 16px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .navbar h3 {
            margin: 0;
            color: #166534;
        }

        .logout-btn {
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
        }

        /* ===== CONTAINER ===== */
        .container {
            padding: 28px;
        }

        /* ===== TITLE ===== */
        .title-box {
            margin-bottom: 24px;
        }

        .title-box h2 {
            margin: 0;
            color: #166534;
        }

        .title-box p {
            color: #666;
        }

        /* ===== SEARCH ===== */
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
        }

        .search-box input {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .search-box button {
            background: #16a34a;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 8px;
            cursor: pointer;
        }

        /* ===== GRID ===== */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        /* ===== CARD ===== */
        .card {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
        }

        .card h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #166534;
        }

        .card p {
            margin: 6px 0;
            color: #444;
            font-size: 14px;
        }

        /* ===== BADGE ===== */
        .stok {
            display: inline-block;
            margin-top: 10px;
            background: #dcfce7;
            color: #166534;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: bold;
        }

        .stok-habis {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ===== BUTTON ===== */
        .btn-pinjam {
            margin-top: 16px;
            width: 100%;
            background: #16a34a;
            color: white;
            border: none;
            padding: 11px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        /* ===== ALERT ===== */
        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        /* ===== EMPTY ===== */
        .empty {
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            color: #666;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">

        <h3>
            📚 SIMPER - Dashboard Anggota
        </h3>

        <div style="display:flex;align-items:center;gap:14px;">

            <span>
                Halo,
                <strong>
                    {{ session('nama_lengkap') }}
                </strong>
            </span>

            <form action="/logout" method="POST">

                @csrf

                <button class="logout-btn">

                    Logout

                </button>

            </form>

        </div>

    </div>

    <!-- CONTENT -->
    <div class="container">

        <!-- ALERT -->
        @if(session('success'))

            <div class="alert-success">

                {{ session('success') }}

            </div>

        @endif

        @if(session('error'))

            <div class="alert-error">

                {{ session('error') }}

            </div>

        @endif

        <!-- TITLE -->
        <div class="title-box">

            <h2>
                📖 Daftar Koleksi Tersedia
            </h2>

            <p>
                Silakan cari dan pinjam koleksi perpustakaan
            </p>

        </div>

        <!-- SEARCH -->
        <form method="GET" action="/anggota/dashboard" class="search-box">

            <input type="text" name="search" placeholder="Cari judul, penulis, atau penerbit..."
                value="{{ request('search') }}">

            <button type="submit">

                Cari

            </button>

        </form>

        <!-- GRID -->
        @if($koleksis->count() > 0)

            <div class="grid">

                @foreach ($koleksis as $koleksi)

                    <div class="card">

                        <h3>
                            {{ $koleksi->judul_koleksi }}
                        </h3>

                        <p>
                            <strong>Penulis:</strong>
                            {{ $koleksi->penulis }}
                        </p>

                        <p>
                            <strong>Penerbit:</strong>
                            {{ $koleksi->penerbit }}
                        </p>

                        <p>
                            <strong>Tahun:</strong>
                            {{ $koleksi->tahun_terbit }}
                        </p>

                        <p>
                            <strong>Jenis:</strong>
                            {{ $koleksi->jenis_koleksi }}
                        </p>

                        <p>
                            <strong>Denda:</strong>
                            Rp {{ number_format($koleksi->denda_harian) }}/hari
                        </p>

                        <!-- STOK -->
                        @if($koleksi->stok > 0)

                            <span class="stok">

                                Stok:
                                {{ $koleksi->stok }}

                            </span>

                        @else

                            <span class="stok stok-habis">

                                Stok Habis

                            </span>

                        @endif

                        <!-- BUTTON -->
                        <form action="/anggota/pinjam/{{ $koleksi->id_koleksi }}" method="POST">

                            @csrf

                            <button type="submit" class="btn-pinjam
                                        {{ $koleksi->stok <= 0 ? 'btn-disabled' : '' }}" {{ $koleksi->stok <= 0 ? 'disabled' : '' }}>

                                📦 Pinjam Koleksi

                            </button>

                        </form>

                    </div>

                @endforeach

            </div>

        @else

            <div class="empty">

                📚 Koleksi tidak ditemukan

            </div>

        @endif

    </div>

</body>

</html>