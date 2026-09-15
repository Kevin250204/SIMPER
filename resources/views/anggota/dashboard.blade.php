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

        /* ===== LAYOUT ===== */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 240px;
            background: linear-gradient(180deg, #0b9444, #0a6c34);
            color: white;
            padding: 20px;
        }

        .logo-box {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .25);
        }

        .logo-box img {
            width: 56px;
            height: 56px;
            object-fit: contain;
        }

        .logo-text h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .logo-text p {
            margin: 2px 0;
            font-size: 12px;
            opacity: 0.9;
        }

        .logo-text span {
            font-size: 11px;
            opacity: 0.85;
        }

        .menu a {
            display: block;
            padding: 12px 14px;
            margin-bottom: 8px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
        }

        .menu a.active,
        .menu a:hover {
            background: rgba(255, 255, 255, .2);
        }

        /* ===== CONTENT ===== */
        .content {
            flex: 1;
            background: white;
            padding: 24px 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h2 {
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ===== SEARCH ===== */
        .search-box {
            margin-bottom: 16px;
        }

        .search-box input {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            width: 300px;
        }

        .search-box button {
            padding: 8px 14px;
            background: #198754;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #e9f7ef;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
            text-align: left;
        }

        th {
            color: #166534;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        /* ===== BUTTON ===== */
        .btn-pinjam {
            background: #16a34a;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        /* ===== ALERT ===== */
        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <!-- SIDEBAR -->
        <div class="sidebar">

            <div class="logo-box">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah">

                <div class="logo-text">
                    <h3>SIMPER</h3>
                    <p>Sistem Informasi Perpustakaan</p>
                    <span>MTs Islamiyah Banat Senori</span>
                </div>
            </div>

            <div class="menu">

                <a href="/anggota/dashboard" class="active">
                    🏠 Dashboardadfadsf
                </a>

                <a href="/anggota/peminjaman">
                    📄 Riwayat Peminjaman
                </a>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="content">

            @include('partials.navbar-anggota')

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="header">
                <h2>📚 Daftar Koleksi Buku</h2>
            </div>

            <!-- SEARCH -->
            <form class="search-box" method="GET" action="/anggota/dashboard">

                <input type="text" name="search" placeholder="Cari buku (judul / penulis)"
                    value="{{ request('search') }}">

                <button type="submit">
                    Cari
                </button>

            </form>

            <!-- TABLE -->
            <table>

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Koleksi</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($koleksis as $i => $koleksi)

                        <tr>

                            <td>{{ $i + 1 }}</td>

                            <td>{{ $koleksi->judul_koleksi }}</td>

                            <td>{{ $koleksi->penulis }}</td>

                            <td>{{ $koleksi->penerbit }}</td>

                            <td>{{ $koleksi->stok }}</td>

                            <td>

                                <form action="/anggota/pinjam/{{ $koleksi->id_koleksi }}" method="POST">

                                    @csrf

                                    <button class="btn-pinjam">
                                        Pinjam
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" style="text-align:center;">
                                Koleksi tidak ditemukan
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</body>

</html>