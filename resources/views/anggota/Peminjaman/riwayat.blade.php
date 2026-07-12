<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman</title>

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
            opacity: .9;
        }

        .logo-text span {
            font-size: 11px;
            opacity: .85;
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
            margin-bottom: 24px;
        }

        .header h2 {
            margin: 0;
            color: #166534;
        }

        .header p {
            margin-top: 6px;
            color: #666;
        }

        /* ===== CARD ===== */
        .card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
            overflow: hidden;
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
            padding: 14px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
            text-align: left;
            vertical-align: top;
        }

        th {
            color: #166534;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        /* ===== BADGE ===== */
        .badge {
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        .menunggu {
            background: #fef3c7;
            color: #92400e;
        }

        .dipinjam {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .terlambat {
            background: #fee2e2;
            color: #991b1b;
        }

        .dikembalikan {
            background: #dcfce7;
            color: #166534;
        }

        /* ===== ITEM LIST ===== */
        .koleksi-list {
            line-height: 1.8;
        }

        /* ===== DENDA ===== */
        .denda {
            color: #dc2626;
            font-weight: bold;
        }

        /* ===== EMPTY ===== */
        .empty {
            text-align: center;
            padding: 30px;
            color: #666;
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

                <a href="/anggota/dashboard">

                    🏠 Dashboard

                </a>

                <a href="/anggota/peminjaman" class="active">

                    📄 Riwayat Peminjaman

                </a>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="content">

            @include('partials.navbar-anggota')

            <!-- HEADER -->
            <div class="header">

                <h2>
                    📄 Riwayat Peminjaman
                </h2>

                <p>
                    Daftar seluruh koleksi yang pernah dipinjam
                </p>

            </div>

            <!-- TABLE CARD -->
            <div class="card">

                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Koleksi</th>

                            <th>Tanggal Pinjam</th>

                            <th>Batas Kembali</th>

                            <th>Status</th>

                            <th>Total Denda</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($peminjamans as $i => $p)

                                                <tr>

                                                    <td>
                                                        {{ $i + 1 }}
                                                    </td>

                                                    <!-- MULTI KOLEKSI -->
                                                    <td class="koleksi-list">

                                                        @foreach($p->detail as $detail)

                                                            • {{ $detail->koleksi->judul_koleksi }}

                                                            <br>

                                                        @endforeach

                                                    </td>

                                                    <td>
                                                        {{ $p->tanggal_pinjam }}
                                                    </td>

                                                    <td>
                                                        {{ $p->tanggal_kembali ?? '-' }}
                                                    </td>

                                                    <td>

                                                        <span class="badge
                                                                                    {{ $p->status_peminjaman }}">

                                                            {{ ucfirst($p->status_peminjaman) }}

                                                        </span>

                                                    </td>

                                                    <!-- TOTAL DENDA -->
                                                    <td class="denda">

                                                        Rp
                                                        {{ number_format(
                                $p->detail->sum('jumlah_denda')
                            ) }}

                                                    </td>

                                                </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="empty">

                                    Belum ada riwayat peminjaman

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>

</html>