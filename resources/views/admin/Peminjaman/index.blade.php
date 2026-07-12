<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Manajemen Peminjaman</title>

    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"> -->

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        margin: 0;
        background: #f4f6f8;
    }

    .content {
        flex: 1;
        margin-left: 300px;
        padding: 24px;
    }

    /* ===== LAYOUT ===== */

    .wrapper {
        display: flex;
        min-height: 100vh;
    }

    /* ===== CONTENT ===== */

    .content {
        flex: 1;
        padding: 24px 30px;
        background: #fff;
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



    /* =====================
   SEARCH
===================== */

    .search-box {

        display: flex;
        gap: 12px;

        margin-bottom: 20px;
    }

    .search-box input {

        flex: 1;

        height: 48px;

        border: 1px solid #d1d5db;

        border-radius: 12px;

        padding: 0 16px;

        font-size: 14px;

        outline: none;
    }

    .search-box input:focus {

        border-color: #0b9444;

        box-shadow: 0 0 0 3px rgba(11, 148, 68, .1);
    }

    .search-box button {

        width: 120px;

        border: none;

        border-radius: 12px;

        background: #0b9444;

        color: white;

        font-weight: 600;

        cursor: pointer;
    }

    /* ===== ALERT ===== */

    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 14px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    /* ===== TABLE ===== */

    .card {
        background: white;

        border-radius: 20px;

        border: 1px solid #e2e8f0;

        box-shadow:
            0 2px 10px rgba(0, 0, 0, .03);

        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #edf7f1;
    }

    th {
        padding: 18px 16px;
        color: #166534;
        font-size: 13px;
        font-weight: 600;
        text-align: left;
        text-transform: uppercase;
    }

    td {
        padding: 20px 16px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    tbody tr {
        transition: .2s;
    }

    tbody tr:hover {
        background: #f8fafc;
    }

    /* ukuran kolom */

    th:nth-child(1),
    td:nth-child(1) {
        width: 60px;
    }

    th:nth-child(2),
    td:nth-child(2) {
        width: 220px;
    }

    th:nth-child(3),
    td:nth-child(3) {
        width: 420px;
    }

    th:nth-child(4),
    td:nth-child(4) {
        width: 140px;
    }

    th:nth-child(5),
    td:nth-child(5) {
        width: 140px;
    }

    th:nth-child(6),
    td:nth-child(6) {
        width: 180px;
    }

    th:nth-child(7),
    td:nth-child(7) {
        width: 260px;
    }

    /* anggota */

    .nama-anggota {
        font-size: 15px;
        font-weight: 600;
        color: #0f172a;
    }

    /* koleksi */

    .koleksi-list {
        line-height: 2;
    }

    /* badge */

    .badge {
        display: inline-block;
        padding: 10px 16px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        min-width: 140px;
        text-align: center;
        letter-spacing: .2px;
    }

    .badge.menunggu {
        background: #fef3c7;
        color: #92400e;
    }

    .badge.dipinjam {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge.dikembalikan {
        background: #dcfce7;
        color: #166534;
    }

    .badge.ditolak {
        background: #fee2e2;
        color: #dc2626;
    }

    /* aksi */

    .aksi {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .aksi form {
        margin: 0;
    }

    /* tombol */

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 110px;
        height: 40px;
        border: none;
        border-radius: 10px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .btn:hover {
        transform: translateY(-2px);

        box-shadow:
            0 6px 14px rgba(0, 0, 0, .12);
    }

    .btn-detail {
        background: #2563eb;
        color: white;
    }

    .btn-approve {
        background: #16a34a;
        color: white;
    }

    .btn-kembali {
        background: #f59e0b;
        color: white;
    }

    .btn-tolak {
        background: #dc2626;
        color: white;
    }

    .btn-tambah {

        position: relative;

        display: inline-flex;
        align-items: center;
        gap: 12px;

        padding: 15px 28px;

        border-radius: 16px;

        background: #16a34a;

        color: white;

        font-weight: 700;

        letter-spacing: .2px;

        text-decoration: none;

        overflow: hidden;

        transition: .3s;
    }

    .btn-tambah::before {

        content: '';

        position: absolute;

        top: 0;
        left: -100%;

        width: 100%;
        height: 100%;

        background: rgba(255, 255, 255, .15);

        transition: .4s;
    }

    .btn-tambah:hover::before {

        left: 100%;
    }

    .btn-tambah:hover {

        transform: translateY(-2px);

        box-shadow:
            0 10px 25px rgba(22, 163, 74, .35);
    }

    /* ===== EMPTY ===== */

    .empty {
        text-align: center;
        padding: 30px;
        color: #666;
    }

    /* ===== RESPONSIVE ===== */

    @media(max-width:1200px) {

        .content {
            padding: 20px;
        }

        table {
            min-width: 1000px;
        }

    }

    .judul-koleksi {
        font-size: 16px;
        font-weight: 500;
        color: #0f172a;
    }

    .tanggal-pinjam {
        font-size: 15px;
        font-weight: 500;
        color: #334155;
    }

    .tanggal-kembali {
        font-size: 15px;
        font-weight: 600;
        color: #334155;
    }
    </style>
</head>

<body>

    <div class="wrapper">

        @include('components.admin-sidebar')

        <!-- CONTENT -->
        <div class="content">

            @include('partials.navbar-admin')

            @if(session('success'))

            <div class="alert-success">

                {{ session('success') }}

            </div>

            @endif

            <!-- HEADER -->
            <div class="header">

            </div>

            <div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
">

                <div></div>

                <a href="{{ route('admin.peminjaman.create') }}" class="btn-tambah">

                    <span>✚</span>

                    <span>Tambah Peminjaman</span>

                </a>

            </div>

            <!-- SEARCH -->

            <form method="GET" action="{{ url('/admin/peminjaman') }}">

                <div class="search-box">

                    <input type="text" name="search" placeholder="Cari nama anggota, NIS, judul koleksi, atau status..."
                        value="{{ request('search') }}">

                    <button type="submit">

                        🔍 Cari

                    </button>

                </div>

            </form>

            <!-- TABLE -->
            <div class="card">

                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Anggota</th>

                            <th>Koleksi Dipinjam</th>

                            <th>Tanggal Pinjam</th>

                            <th>Tanggal Kembali</th>

                            <th>Status</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($peminjamans as $i => $peminjaman)

                        <tr>

                            <td>
                                {{ $peminjamans->firstItem() + $loop->index }}
                            </td>

                            <td class="nama-anggota">

                                {{ $peminjaman->anggota->nama_lengkap }}

                                <br>

                                <small style="color:#64748b;">
                                    {{ $peminjaman->anggota->nis ?? '' }}
                                </small>

                            </td>

                            <!-- MULTI KOLEKSI -->
                            <td class="koleksi-list">

                                @foreach($peminjaman->detail as $detail)

                                <div class="judul-koleksi">
                                    {{ $detail->koleksi->judul_koleksi }}
                                </div>

                                @endforeach

                            </td>

                            <td>
                                <span class="tanggal-pinjam">
                                    {{ $peminjaman->tanggal_pinjam }}
                                </span>
                            </td>

                            <td>
                                <span class="tanggal-kembali">
                                    {{ $peminjaman->tanggal_kembali ?? '-' }}
                                </span>
                            </td>

                            <td>

                                @php
                                $statusClass = match (strtolower($peminjaman->status_peminjaman)) {

                                'proses' => 'menunggu',

                                'dipinjam' => 'dipinjam',

                                'selesai' => 'dikembalikan',

                                'ditolak' => 'ditolak',

                                default => 'menunggu'
                                };
                                @endphp

                                <span class="badge {{ $statusClass }}">

                                    @switch(strtolower($peminjaman->status_peminjaman))

                                    @case('proses')
                                    Menunggu Persetujuan
                                    @break

                                    @case('dipinjam')
                                    Sedang Dipinjam
                                    @break

                                    @case('selesai')
                                    Dikembalikan
                                    @break

                                    @case('ditolak')
                                    Ditolak
                                    @break

                                    @default
                                    {{ ucfirst($peminjaman->status_peminjaman) }}

                                    @endswitch

                                </span>

                            </td>


                            </td>

                            <td>

                                <div class="aksi">

                                    <!-- DETAIL -->
                                    <a href="/admin/peminjaman/{{ $peminjaman->id_peminjaman }}" class="btn btn-detail">

                                        Detail

                                    </a>

                                    <!-- APPROVE -->
                                    @if(
                                    in_array(
                                    strtolower($peminjaman->status_peminjaman),
                                    ['proses', 'menunggu']
                                    )
                                    )

                                    <form action="/admin/peminjaman/{{ $peminjaman->id_peminjaman }}/approve"
                                        method="POST">

                                        @csrf
                                        @method('PUT')

                                        <button type="submit" class="btn btn-approve"
                                            onclick="return confirm('Setujui peminjaman ini?')">

                                            ✅ Approve

                                        </button>

                                    </form>

                                    <form action="{{ route('admin.peminjaman.tolak', $peminjaman->id_peminjaman) }}"
                                        method="POST">

                                        @csrf
                                        @method('PUT')

                                        <button type="submit" class="btn btn-tolak"
                                            onclick="return confirm('Tolak peminjaman ini?')">

                                            ❌ Tolak

                                        </button>

                                    </form>

                                    @endif

                                    <!-- KEMBALIKAN -->
                                    @if(
                                    strtolower($peminjaman->status_peminjaman)
                                    == 'dipinjam'
                                    )

                                    <form action="/admin/peminjaman/{{ $peminjaman->id_peminjaman }}/kembalikan"
                                        method="POST">

                                        @csrf
                                        @method('PUT')

                                        <button type="submit" class="btn btn-kembali"
                                            onclick="return confirm('Kembalikan koleksi ini?')">

                                            🔄 Kembalikan

                                        </button>

                                    </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7" class="empty">

                                Belum ada data peminjaman

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

                <x-pagination :data="$peminjamans" />

            </div>

        </div>

    </div>

</body>

</html>