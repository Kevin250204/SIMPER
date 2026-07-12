<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Koleksi</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f4f6f8;
            padding: 30px;
        }

        /* ===== BACK BUTTON ===== */
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #166534;
            font-weight: bold;
        }

        /* ===== CARD ===== */
        .card {
            background: #fff;
            padding: 24px;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .08);
        }

        /* ===== TITLE ===== */
        h2 {
            margin-top: 0;
            color: #166534;
        }

        h3 {
            margin-top: 30px;
            color: #166534;
        }

        /* ===== INFO ===== */
        .info {
            margin-top: 10px;
            line-height: 1.8;
        }

        .info strong {
            color: #111827;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background: #e9f7ef;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
            font-size: 14px;
        }

        th {
            color: #166534;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        /* ===== BADGE ===== */
        .badge-plus {
            color: #16a34a;
            font-weight: bold;
        }

        .badge-minus {
            color: #dc2626;
            font-weight: bold;
        }

        .badge-zero {
            color: #6b7280;
            font-weight: bold;
        }

        /* ===== EMPTY ===== */
        .empty {
            text-align: center;
            color: #6b7280;
            padding: 18px;
        }
    </style>
</head>

<body>

    <!-- BACK -->
    <a href="/admin/koleksi" class="back-btn">

        ⬅ Kembali

    </a>

    <!-- CARD -->
    <div class="card">

        <!-- TITLE -->
        <h2>
            📚 {{ $koleksi->judul_koleksi }}
        </h2>

        <!-- INFO -->
        <div class="info">

            <strong>ISBN :</strong>
            {{ $koleksi->isbn }}

            <br>

            <strong>Penulis :</strong>
            {{ $koleksi->penulis }}

            <br>

            <strong>Penerbit :</strong>
            {{ $koleksi->penerbit }}

            <br>

            <strong>Tahun Terbit :</strong>
            {{ $koleksi->tahun_terbit }}

            <br>

            <strong>Jenis Koleksi :</strong>
            {{ $koleksi->jenis_koleksi }}

            <br>

            <br>

            <strong>Deskripsi :</strong>

            <br>

            <div style="
                margin-top:8px;
                padding:12px;
                background:#f9fafb;
                border-radius:8px;
                line-height:1.8;
                ">
                {{ $koleksi->deskripsi ?? 'Belum ada deskripsi.' }}
            </div>

            <strong>Denda Harian :</strong>
            Rp {{ number_format($koleksi->denda_harian) }}

            <br>

            <strong>Stok Saat Ini :</strong>
            {{ $koleksi->stok }}

        </div>

        <!-- HISTORY -->
        <h3>
            📦 Riwayat Stock Opname
        </h3>

        <table>

            <thead>

                <tr>

                    <th>Tanggal</th>

                    <th>Stok Sistem</th>

                    <th>Stok Fisik</th>

                    <th>Selisih</th>

                    <th>Jumlah Terbaru</th>

                    <th>Keterangan</th>

                </tr>

            </thead>

            <tbody>

                @forelse($riwayat as $r)

                    <tr>

                        <td>
                            {{ $r->tanggal_opname }}
                        </td>

                        <td>
                            {{ $r->stok_sistem }}
                        </td>

                        <td>
                            {{ $r->stok_fisik }}
                        </td>

                        <td>

                            @if($r->selisih > 0)

                                <span class="badge-plus">

                                    +{{ $r->selisih }}

                                </span>

                            @elseif($r->selisih < 0) <span class="badge-minus">

                                    {{ $r->selisih }}

                                </span>

                            @else

                                <span class="badge-zero">

                                    0

                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $r->jumlah_terbaru }}
                        </td>

                        <td>
                            {{ $r->keterangan ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="empty">

                            Belum ada riwayat stock opname

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</body>

</html>