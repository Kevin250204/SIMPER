<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 2px;
        }

        .info {
            margin-bottom: 15px;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .summary td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #0f6d3a;
            color: white;
            padding: 8px;
            text-align: center;
        }

        .table td {
            border: 1px solid #ddd;
            padding: 7px;
        }

        .table tr:nth-child(even) {
            background: #f5f5f5;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
        }

        .logo {
            width: 70px;
            height: auto;
        }

        .header-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .header-table td {
            border: none;
        }

        .school-name {
            text-align: center;
        }

        .signature {
            margin-top: 50px;
            width: 250px;
            float: right;
            text-align: center;
            font-size: 12px;
        }

        @page {
            margin: 90px 30px 80px 30px;
        }

        .page-number {
            position: fixed;
            bottom: -40px;
            right: 0;
            font-size: 10px;
        }

        .pdf-footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            font-size: 10px;
            color: #666;
        }
    </style>

</head>

<body>

    <table class="header-table">
        <tr>

            <td width="15%">
                <img src="{{ public_path('images/logo.png') }}" class="logo">
            </td>

            <td class="school-name">

                <h2>
                    MTs ISLAMIYAH BANAT
                </h2>

                <p>
                    Senori - Tuban
                </p>

                <h3>
                    LAPORAN PEMINJAMAN KOLEKSI
                </h3>

                <p>
                    Periode :
                    {{ $periodeAwal }}
                    s/d
                    {{ $periodeAkhir }}
                </p>

            </td>

        </tr>
    </table>

    <hr>

    <p>
        Tanggal Cetak :
        {{ now()->timezone('Asia/Jakarta')->format('d-m-Y H:i') }} WIB
    </p>

    <table class="summary">
        <tr>
            <td>Total Peminjaman</td>
            <td>{{ $totalPeminjaman }}</td>

            <td>Sedang Aktif</td>
            <td>{{ $sedangAktif }}</td>
        </tr>

        <tr>
            <td>Selesai Kembali</td>
            <td>{{ $selesai }}</td>

            <td>Terlambat</td>
            <td>{{ $terlambat }}</td>
        </tr>

        <tr>
            <td>Total Denda</td>
            <td colspan="3">
                Rp {{ number_format($totalDenda, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <table class="table">

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

            @foreach($laporan as $index => $item)

                <tr>

                    <td>{{ $index + 1 }}</td>

                    <td>
                        {{ $item->anggota->nama_lengkap }}
                    </td>

                    <td>

                        @foreach($item->detail as $noKoleksi => $detail)

                            {{ $noKoleksi + 1 }}.
                            {{ $detail->koleksi->judul_koleksi }}

                            @if(!$loop->last)
                                <br>
                            @endif

                        @endforeach

                    </td>

                    <td>
                        {{ $item->tanggal_pinjam }}
                    </td>

                    <td>
                        {{ $item->tanggal_kembali }}
                    </td>

                    <td>
                        Rp {{ number_format($item->total_denda, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ ucfirst($item->status_peminjaman) }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

    <div class="signature">

        <p>
            Senori, {{ now()->timezone('Asia/Jakarta')->format('d F Y') }}
        </p>

        <p>
            Admin Perpustakaan
        </p>

        <br><br><br>

        <strong>
            ______________________
        </strong>

    </div>

    <div class="pdf-footer">
        Dicetak dari Sistem Informasi Perpustakaan (SIMPER)
    </div>

    <script type="text/php">
        if (isset($pdf)) {

    $pdf->page_script('
        $font = $fontMetrics->get_font("Helvetica");

        $pdf->text(
            500,
            820,
            "Halaman $PAGE_NUM dari $PAGE_COUNT",
            $font,
            10
        );
    ');
}
</script>

</body>

</html>