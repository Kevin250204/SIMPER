<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    <title>Peminjaman Koleksi</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
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

        .status-proses {
            display: inline-block;
            margin-top: 8px;
            padding: 6px 12px;
            background: #fff7ed;
            color: #ea580c;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-dipinjam {
            display: inline-block;
            margin-top: 8px;
            padding: 6px 12px;
            background: #ecfdf5;
            color: #0F8248;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-selesai {
            color: #2563eb;
            font-weight: 700;
        }

        .status-ditolak {
            color: #dc2626;
            font-weight: 700;
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

                        <form action="{{ route('anggota.perpanjang', $item->id_peminjaman) }}" method="POST">

                            @csrf

                            <button type="submit" class="btn-perpanjang">

                                Perpanjang

                            </button>

                        </form>

                    </div>

                @endif

            @endforeach

        @endforeach

        <br><br><br>

        <div class="section-header">

            <div class="section-title">
                📚 Riwayat Peminjaman
            </div>

        </div>

        <div class="table-box">

            <table>

                <thead>
                    <tr>
                        <th>Koleksi</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($riwayat as $item)

                        <tr>

                            <td>

                                @foreach($item->detail as $detail)

                                    <div class="riwayat-book">

                                        @if($detail->koleksi?->gambar)

                                            <img src="{{ asset('uploads/koleksi/' . $detail->koleksi->gambar) }}"
                                                class="riwayat-cover">

                                        @else

                                            <img src="{{ asset('images/no-cover.png') }}" class="riwayat-cover">

                                        @endif

                                        <div>

                                            <div class="riwayat-judul">

                                                {{ $detail->koleksi->judul_koleksi }}

                                            </div>

                                            <div class="riwayat-penulis">

                                                {{ $detail->koleksi->penulis }}

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </td>

                            <td>
                                {{ $item->tanggal_kembali }}
                            </td>

                            <td>

                                @if($detail->status_item == 'menunggu')

                                    <span class="status-proses">
                                        Menunggu Persetujuan
                                    </span>

                                @elseif($detail->status_item == 'dipinjam')

                                    <span class="status-dipinjam">
                                        Dipinjam
                                    </span>

                                @elseif($detail->status_item == 'dikembalikan')

                                    <span class="status-selesai">
                                        Dikembalikan
                                    </span>

                                @elseif($detail->status_item == 'terlambat')

                                    <span class="status-ditolak">
                                        Terlambat
                                    </span>

                                @elseif($detail->status_item == 'hilang')

                                    <span class="status-ditolak">
                                        Hilang
                                    </span>

                                @elseif($detail->status_item == 'rusak')

                                    <span class="status-ditolak">
                                        Rusak
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

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