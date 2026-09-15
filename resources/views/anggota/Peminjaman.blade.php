<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">

    <title>Peminjaman Koleksi</title>

    <style>
        body {

            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        .container,
        .container * {

            box-sizing: border-box;

        }

        body {
            background: #f8f8f8;
        }

        .container {
            max-width: 1200px;
            margin: 100px auto 0;
            padding: 50px;
        }

        .title {
            font-size: 56px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #777;
            margin-bottom: 60px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            margin-bottom: 25px;
            font-size: 20px;
            font-weight: 700;
        }

        .btn-pinjam {
            background: #0F8248;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            text-decoration: none;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .pinjam-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            margin-bottom: 15px;
        }

        .book-info {
            display: flex;
            gap: 15px;
        }

        .cover {
            width: 70px;
            height: 100px;
            border-radius: 8px;
            object-fit: cover;
        }

        .book-detail h4 {
            margin-bottom: 5px;
        }

        .book-detail p {
            color: #999;
            margin-bottom: 8px;
        }

        .deadline {
            color: #666;
        }

        .sisa {
            color: #16a34a;
            font-weight: 700;
        }

        .terlambat {
            color: #dc2626;
            font-weight: 700;
        }

        .btn-perpanjang {
            padding: 10px 20px;
            border: 1px solid #0F8248;
            color: #0F8248;
            border-radius: 10px;
            background: white;
            cursor: pointer;
        }

        .table-box {
            background: white;
            border-radius: 20px;
            border: 1px solid #ddd;
            padding: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            color: #888;
            padding-bottom: 20px;
        }

        td {
            padding: 15px 0;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 120px;

            padding: 8px 16px;

            border-radius: 999px;

            font-size: 13px;
            font-weight: 600;

            text-align: center;
        }

        .status-menunggu {
            background: #FFF7ED;
            color: #EA580C;
        }

        .status-dipinjam {
            background: #ECFDF5;
            color: #15803D;
        }

        .status-dikembalikan {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .status-terlambat {
            background: #FEE2E2;
            color: #DC2626;
        }

        .status-ditolak {
            background: #FEE2E2;
            color: #DC2626;
        }

        .status-rusak {
            background: #FEE2E2;
            color: #DC2626;
        }

        .status-hilang {
            background: #FEE2E2;
            color: #DC2626;
        }


        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #FEE2E2;
            color: #B91C1C;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .footer {
            margin-top: 80px;
            background: #0F8248;
            color: white;
            text-align: center;
            padding: 30px;
        }

        /* =========================
   RIWAYAT KOLEKSI
========================= */

        .riwayat-book {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .riwayat-book:last-child {
            margin-bottom: 0;
        }

        .riwayat-cover {
            width: 55px;
            height: 75px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .riwayat-judul {
            font-size: 16px;
            font-weight: 600;
            color: #222;
        }

        .riwayat-penulis {
            margin-top: 4px;
            font-size: 13px;
            color: #888;
        }

        .status-ditolak {
            background: #fee2e2;
            color: #dc2626;
            padding: 8px 14px;
            border-radius: 20px;
            font-weight: 600;
        }

        .status-perpanjang {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 10px 18px;

            border-radius: 10px;

            background: #e8f8ec;
            color: #198754;

            font-weight: 600;
            font-size: 14px;

            border: 1px solid #b7e4c7;
        }

        .riwayat-card {

            display: flex;

            align-items: center;

            gap: 18px;

            padding: 18px 22px;

            border-bottom: 1px solid #ededed;

        }

        .riwayat-cover img {

            width: 62px;

            height: 86px;

            object-fit: cover;

            border-radius: 8px;

            box-shadow: 0 2px 6px rgba(0, 0, 0, .08);

        }

        .riwayat-info {

            flex: 1;

        }

        .riwayat-info h3 {

            margin: 0;

            font-size: 18px;

            font-weight: 700;

            color: #222;

        }

        .riwayat-info p {

            margin-top: 4px;

            margin-bottom: 8px;

            color: #7d7d7d;

            font-size: 14px;

        }

        .riwayat-tanggal {

            display: flex;

            gap: 22px;

            font-size: 13px;

            color: #777;

        }

        .riwayat-status {

            width: 150px;

            display: flex;

            justify-content: center;

            align-items: center;

        }

        .riwayat-toolbar {

            display: flex;

            gap: 12px;

            margin: 25px 0 20px;

            flex-wrap: wrap;

        }

        .filter {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            padding: 10px 22px;

            border: 1px solid #d9d9d9;
            border-radius: 999px;

            background: #fff;
            color: #333;

            text-decoration: none;

            transition: .2s;
        }

        .filter:hover {
            background: #f4f4f4;
        }

        .filter.active {
            background: #111;
            color: #fff;
            border-color: #111;
        }

        .riwayat-search {

            flex: 1;

        }

        .riwayat-search input {

            width: 100%;

            height: 46px;

            border-radius: 12px;

            border: 1px solid #ddd;

            padding: 0 16px;

            font-size: 15px;

        }

        .riwayat-search-row {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            margin-bottom: 24px;

        }

        .riwayat-total {

            white-space: nowrap;

            font-size: 14px;

            color: #777;

        }

        .search-form {
            flex: 1;
            display: flex;
            gap: 14px;
        }

        .search-form button {

            width: 130px;

            height: 48px;

            border: none;

            border-radius: 12px;

            background: #16a34a;

            color: #fff;

            font-weight: 600;

            cursor: pointer;

        }

        .search-form button:hover {
            background: #14843b;
        }

        .search-input {

            flex: 1;

            height: 48px;

            border: 1px solid #ddd;

            border-radius: 12px;

            padding: 0 18px;

            font-size: 15px;

            outline: none;

        }

        .search-input:focus {

            border-color: #16a34a;

        }

        .filter-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 24px;
            height: 24px;

            margin-left: 8px;

            background: #f1f5f9;
            color: #555;

            border-radius: 50%;

            font-size: 12px;
            font-weight: 700;
        }

        .filter.active .filter-count {
            background: #16a34a;
            color: #fff;
        }

        .riwayat-denda {

            display: inline-block;

            margin-top: 10px;

            padding: 5px 10px;

            background: #FEE2E2;

            color: #DC2626;

            border: 1px solid #FCA5A5;

            border-radius: 999px;

            font-size: 9px;

            font-weight: 700;

        }
    </style>
</head>

<body>

    @include('components.navbar')

    <div class="container">

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

        <h1 class="title">
            Peminjaman Koleksi
        </h1>

        <p class="subtitle">
            Kelola yang sedang anda pinjam,
            lihat riwayat peminjaman dan
            temukan koleksi untuk dipinjam
        </p>

        <div class="section-header">

            <div class="section-title">
                📚 Peminjaman Aktif
            </div>

            <a href="{{ route('anggota.peminjaman.create') }}" class="btn-pinjam">
                Pinjam Koleksi
            </a>

        </div>

        @foreach($aktif as $item)

            @foreach($item->detail as $detail)

                @if(in_array($detail->status_item, ['dipinjam', 'terlambat']))

                    <div class="pinjam-card">

                        <div class="book-info">

                            @if($detail->koleksi?->gambar)

                                <img class="cover" src="{{ asset('uploads/koleksi/' . $detail->koleksi->gambar) }}">

                            @else

                                <img class="cover" src="{{ asset('images/no-cover.png') }}">

                            @endif

                            <div class="book-detail">

                                <h4>
                                    {{ $detail->koleksi->judul_koleksi }}
                                </h4>

                                <p>
                                    {{ $detail->koleksi->penulis }}
                                </p>

                                <div class="deadline">

                                    Tempo:
                                    {{ $item->tanggal_kembali }}

                                    @if($detail->status_item == 'dipinjam')

                                        <span class="sisa">
                                            • Sisa {{ $item->sisa_hari }} Hari
                                        </span>

                                    @elseif($detail->status_item == 'terlambat')

                                        <span class="terlambat">
                                            • Terlambat {{ abs($item->sisa_hari) }} Hari
                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>

                        @if($item->sudah_diperpanjang == 0)
                            <form action="{{ route('anggota.perpanjang', $item->id_peminjaman) }}" method="POST">

                                @csrf

                                <button type="submit" class="btn-perpanjang">

                                    Perpanjang

                                </button>

                            </form>

                        @else

                            <div class="status-perpanjang">
                                ✓ Sudah Diperpanjang
                            </div>

                        @endif

                    </div>

                @endif

            @endforeach

        @endforeach

        <br><br><br>

        <div id="riwayat" class="section-header">

            <div class="section-title">
                Riwayat Peminjaman
            </div>

        </div>

        <div class="riwayat-toolbar">

            <a href="{{ route('anggota.peminjaman') }}#riwayat" class="filter {{ request('status') ? '' : 'active' }}">
                Semua

                <span class="filter-count">
                    {{ $jumlahStatus['semua'] }}
                </span>
            </a>

            <a href="{{ route('anggota.peminjaman', [
    'status' => 'dikembalikan',
    'search' => request('search')
]) }}#riwayat" class="filter {{ request('status') == 'dikembalikan' ? 'active' : '' }}">
                Dikembalikan

                <span class="filter-count">
                    {{ $jumlahStatus['dikembalikan'] }}
                </span>
            </a>

            <a href="{{ route('anggota.peminjaman', [
    'status' => 'terlambat',
    'search' => request('search')
]) }}#riwayat" class="filter {{ request('status') == 'terlambat' ? 'active' : '' }}">
                Terlambat

                <span class="filter-count">
                    {{ $jumlahStatus['terlambat'] }}
                </span>
            </a>

            <a href="{{ route('anggota.peminjaman', [
    'status' => 'ditolak',
    'search' => request('search')
]) }}#riwayat" class="filter {{ request('status') == 'ditolak' ? 'active' : '' }}">
                Ditolak

                <span class="filter-count">
                    {{ $jumlahStatus['ditolak'] }}
                </span>
            </a>

            <a href="{{ route('anggota.peminjaman', [
    'status' => 'hilang',
    'search' => request('search')
]) }}#riwayat" class="filter {{ request('status') == 'hilang' ? 'active' : '' }}">
                Hilang

                <span class="filter-count">
                    {{ $jumlahStatus['hilang'] }}
                </span>
            </a>

            <a href="{{ route('anggota.peminjaman', [
    'status' => 'rusak',
    'search' => request('search')
]) }}#riwayat" class="filter {{ request('status') == 'rusak' ? 'active' : '' }}">
                Rusak

                <span class="filter-count">
                    {{ $jumlahStatus['rusak'] }}
                </span>
            </a>

        </div>

        <div class="riwayat-search-row">

            <form method="GET" action="{{ route('anggota.peminjaman') }}#riwayat" class="search-form">

                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif

                <input class="search-input" type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari judul koleksi">

                <button type="submit">
                    Cari
                </button>

            </form>

            <div class="riwayat-total">
                Menemukan {{ $riwayat->total() }} data
            </div>

        </div>

        <div class="table-box">

            @foreach($riwayat as $detail)

                <div class="riwayat-card">

                    <div class="riwayat-cover">

                        <img src="{{ asset('uploads/koleksi/' . $detail->koleksi->gambar) }}" alt="cover">

                    </div>

                    <div class="riwayat-info">

                        <h3>

                            {{ $detail->koleksi->judul_koleksi }}

                        </h3>

                        <p>

                            {{ $detail->koleksi->penulis }}

                        </p>

                        <div class="riwayat-tanggal">

                            <span>

                                Pinjam :
                                {{ $detail->peminjaman->tanggal_pinjam }}

                            </span>

                            <span>

                                Kembali :
                                {{ $detail->peminjaman->tanggal_kembali }}

                            </span>

                        </div>

                        @if(in_array($detail->status_item, ['terlambat', 'hilang', 'rusak']))

                            <div class="riwayat-denda">

                                Denda :
                                Rp {{ number_format($detail->jumlah_denda, 0, ',', '.') }}

                            </div>

                        @endif

                    </div>

                    <div class="riwayat-status">

                        @php

                            $status = strtolower($detail->status_item);

                        @endphp

                        <span class="status-badge status-{{ $status }}">

                            {{ ucfirst($detail->status_item) }}

                        </span>

                    </div>

                </div>

            @endforeach

        </div>

        <x-pagination :data="$riwayat" anchor="riwayat" />

    </div>

    <footer class="footer">

        <h3>
            Perpustakaan MTs Islamiyah Banat
        </h3>

        <br>

        Sistem Informasi Perpustakaan -
        Jl. K. Djoned No.62 Jatisari
        Senori Tuban Jawa Timur


    </footer>

</body>

</html>