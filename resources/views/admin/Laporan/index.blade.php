<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>

    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f8;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .content {
            flex: 1;
            margin-left: 300px;
            padding: 25px 30px;
        }

        .page-title {
            font-size: 30px;
            font-weight: 700;
            color: #166534;
        }

        .page-subtitle {
            color: #64748b;
            margin-top: 5px;
            margin-bottom: 25px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
        }

        .card h4 {
            color: #64748b;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .card h2 {
            font-size: 34px;
            color: #166534;
        }

        .filter-card {
            background: white;
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
        }

        .filter-grid {
            display: grid;
            grid-template-columns:
                1fr 1fr 1fr 2fr;
            gap: 15px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .table-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .06);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #e9f7ef;
            color: #166534;
            padding: 15px;
            text-align: left;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .btn-pdf {
            background: #0b9444;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: 600;
        }

        .header-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .badge {
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .dipinjam {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .selesai {
            background: #dcfce7;
            color: #166534;
        }

        .terlambat {
            background: #fee2e2;
            color: #dc2626;
        }

        .ditolak {
            background: #fee2e2;
            color: #dc2626;
        }
    </style>
</head>

<body>

    <div class="wrapper">

        @include('components.admin-sidebar')

        <div class="content">

            @include('partials.navbar-admin')

            <div class="header-action">

                <div>

                    <div class="page-title">

                    </div>

                    <div class="page-subtitle">

                    </div>

                </div>

                @if($laporan->count() > 0)
                    <a href="{{ route('admin.laporan.pdf', request()->query()) }}" class="btn-pdf">
                        🖨 Cetak PDF
                    </a>
                @else
                            <button class="btn-pdf" disabled style="
                        background:#9ca3af;
                        cursor:not-allowed;
                        opacity:.7;
                    " title="Tidak ada data yang dapat dicetak">
                                🖨 Cetak PDF
                            </button>
                @endif

            </div>

            {{-- CARD STATISTIK --}}

            <div class="cards">

                <div class="card">
                    <h4>Total Peminjaman</h4>
                    <h2>{{ $totalPeminjaman }}</h2>
                </div>

                <div class="card">
                    <h4>Sedang Aktif</h4>
                    <h2>{{ $sedangAktif }}</h2>
                </div>

                <div class="card">
                    <h4>Selesai Kembali</h4>
                    <h2>{{ $selesaiKembali }}</h2>
                </div>

                <div class="card">
                    <h4>Terlambat</h4>
                    <h2>{{ $terlambat }}</h2>
                </div>

                <div class="card">
                    <h4>Total Denda</h4>
                    <h2>
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </h2>
                </div>

            </div>

            {{-- FILTER --}}
            <form method="GET" action="{{ route('admin.laporan') }}">
                <div class="filter-card">

                    <div class="filter-grid">

                        <input type="date" name="tanggal_awal" class="form-control"
                            value="{{ request('tanggal_awal') }}">

                        <input type="date" name="tanggal_akhir" class="form-control"
                            value="{{ request('tanggal_akhir') }}">

                        <select name="status" class="form-control">

                            <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>
                                Semua Status
                            </option>

                            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>
                                Dipinjam
                            </option>

                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                Ditolak
                            </option>

                        </select>

                        <input type="text" name="keyword" class="form-control" placeholder="Cari anggota atau koleksi"
                            value="{{ request('keyword') }}">

                    </div>

                    <div style="margin-top:15px">

                        <button type="submit" class="btn-pdf">

                            Cari Data

                        </button>

                    </div>

                </div>
            </form>


            {{-- TABEL --}}

            <div class="table-card">

                <table>

                    <thead>
                        <tr>

                            <th>No</th>
                            <th>Anggota</th>
                            <th>Koleksi</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Denda</th>
                            <th>Status</th>

                        </tr>
                    </thead>

                    <tbody>

                        @if($laporan->count())

                            @foreach($laporan as $index => $item)

                                <tr>

                                    <td>
                                        {{ $laporan->firstItem() + $index }}
                                    </td>

                                    <td>
                                        {{ $item->anggota->nama_lengkap }}
                                    </td>

                                    <td>

                                        @foreach($item->detail as $detail)

                                            {{ $detail->koleksi->judul_koleksi }}
                                            <br>

                                        @endforeach

                                    </td>

                                    <td>{{ $item->tanggal_pinjam }}</td>
                                    <td>{{ $item->tanggal_kembali }}</td>

                                    <td>
                                        Rp {{ number_format($item->total_denda, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        <span class="badge {{ $item->status_peminjaman }}">
                                            {{ ucfirst($item->status_peminjaman) }}
                                        </span>
                                    </td>

                                </tr>

                            @endforeach

                        @else

                            <tr>

                                <td colspan="7" style="text-align:center;padding:30px;">

                                    Data tidak ditemukan

                                </td>

                            </tr>

                        @endif

                    </tbody>

                </table>

            </div>
            <x-pagination :data="$laporan" />

        </div>

    </div>

</body>

</html>