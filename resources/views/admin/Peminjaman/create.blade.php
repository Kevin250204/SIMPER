<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Peminjaman</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            background: #f4f7f6;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .content {
            flex: 1;
            margin-left: 300px;
            padding: 30px;
        }

        .header {
            margin-bottom: 24px;
        }

        .header h2 {
            margin: 0;
            color: #0f5132;
            font-size: 34px;
            font-weight: 700;
        }

        .header p {
            margin-top: 8px;
            color: #64748b;
            font-size: 16px;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 28px;
            box-shadow:
                0 10px 30px rgba(0, 0, 0, .05);
        }

        /* ========================
   SEARCH
======================== */

        .search-box {
            display: flex;
            gap: 14px;
            margin-bottom: 24px;
        }

        .search-box input {
            flex: 1;
            height: 56px;
            border: 1px solid #dbe3e8;
            border-radius: 14px;
            padding: 0 18px;
            font-size: 15px;
            transition: .25s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #16a34a;
            box-shadow: 0 0 0 4px rgba(22, 163, 74, .12);
        }

        .search-box button {
            width: 140px;
            border: none;
            border-radius: 14px;
            background: #16a34a;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: .25s;
        }

        .search-box button:hover {
            background: #15803d;
        }

        /* ========================
   DATA ANGGOTA
======================== */

        .anggota-box {
            background: linear-gradient(135deg,
                    #f0fdf4,
                    #dcfce7);

            border: 1px solid #bbf7d0;
            border-radius: 16px;

            padding: 22px;
            margin-bottom: 24px;
        }

        .anggota-box h3 {
            margin: 0 0 10px;
            color: #166534;
        }

        .anggota-box strong {
            font-size: 22px;
            color: #14532d;
        }

        .anggota-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .anggota-nis {
            margin-top: 8px;
            color: #475569;
        }

        .anggota-stat {
            text-align: center;
            background: white;
            padding: 16px 24px;
            border-radius: 14px;
            min-width: 160px;

            box-shadow:
                0 4px 12px rgba(0, 0, 0, .05);
        }

        .anggota-stat span {
            color: #64748b;
            font-size: 13px;
        }

        .anggota-stat h2 {
            margin: 8px 0 0;
            color: #16a34a;
            font-size: 34px;
        }

        /* ========================
   TABLE
======================== */

        .table-wrapper {
            overflow: hidden;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            margin-bottom: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #edf7f1;
        }

        thead th {
            padding: 18px;
            color: #14532d;
            font-size: 15px;
            font-weight: 700;
        }

        tbody td {
            padding: 16px 18px;
            border-top: 1px solid #edf2f7;
        }

        tbody tr {
            transition: .2s;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        /* ========================
   BUTTON PINJAM
======================== */

        .btn-pinjam {
            background: #16a34a;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: .25s;
        }

        .btn-pinjam:hover {
            background: #15803d;
            transform: translateY(-2px);
        }

        /* ========================
   KOLEKSI DIPILIH
======================== */

        .selected-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .selected-box h3 {
            margin-top: 0;
            color: #0f172a;
        }

        .selected-item {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 10px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-remove {
            background: #ef4444;
            color: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            cursor: pointer;
        }

        /* ========================
   SIMPAN
======================== */

        .btn-simpan {
            background: #16a34a;
            color: white;
            border: none;
            padding: 14px 26px;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: .25s;
        }

        .btn-simpan:hover {
            background: #15803d;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="wrapper">

        @include('components.admin-sidebar')

        <div class="content">

            @include('partials.navbar-admin')

            <div class="header">

                <h2>➕ Tambah Peminjaman</h2>

                <p>
                    Pilih anggota dan koleksi yang akan dipinjam
                </p>

            </div>

            <div class="card">

                <form action="{{ route('admin.peminjaman.cari-anggota') }}" method="GET" class="search-box"
                    onsubmit="resetPilihan()">

                    <input type="text" name="keyword" placeholder="Cari Nama atau NIS Anggota..."
                        value="{{ request('keyword') }}">

                    <button type="submit">

                        Cari

                    </button>

                </form>

                @if($anggota)

                    <div class="anggota-box">

                        <div class="anggota-header">

                            <div>

                                <h3>
                                    👤 Data Anggota
                                </h3>

                                <strong>
                                    {{ $anggota->nama_lengkap }}
                                </strong>

                                <div class="anggota-nis">

                                    NIS :
                                    {{ $anggota->nis }}

                                </div>

                            </div>

                            <div class="anggota-stat">

                                <span>

                                    📚 Sedang Dipinjam

                                </span>

                                <h2>
                                    {{ $jumlahDipinjam ?? 0 }}
                                </h2>

                            </div>

                        </div>

                    </div>

                    <form method="GET" action="{{ route('admin.peminjaman.cari-koleksi') }}" style="margin-bottom:20px;">

                        <input type="hidden" name="id_anggota" value="{{ $anggota->id_anggota }}">

                        <div class="search-box">

                            <input type="text" name="judul" placeholder="Cari judul koleksi">

                            <button type="submit">

                                Cari Koleksi

                            </button>

                        </div>

                    </form>

                    <form action="{{ route('admin.peminjaman.store') }}" method="POST">


                        @csrf

                        <input type="hidden" name="id_anggota" value="{{ $anggota->id_anggota }}">

                        <div style="margin-bottom:20px;">



                        </div>

                        <table
                            style="
                                                                                                                                                                    width:100%;
                                                                                                                                                                    border-collapse:collapse;
                                                                                                                                                                    margin-bottom:20px;
                                                                                                                                                                ">

                            <thead>

                                <tr style="background:#edf7f1;">

                                    <th style="padding:14px;">
                                        Judul Koleksi
                                    </th>

                                    <th>
                                        Jenis
                                    </th>

                                    <th>
                                        Stok
                                    </th>

                                    <th width="120">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>

                            <tbody id="koleksiTable">

                                @if(!empty($koleksis) && $koleksis->count())

                                    @foreach($koleksis as $koleksi)

                                        <tr>

                                            <td style="padding:14px;">
                                                {{ $koleksi->judul_koleksi }}
                                            </td>

                                            <td>
                                                {{ $koleksi->jenis_koleksi }}
                                            </td>

                                            <td>
                                                {{ $koleksi->stok }}
                                            </td>

                                            <td>

                                                <button type="button" class="btn-pinjam" onclick="tambahKoleksi(
                                                                                                                                '{{ $koleksi->id_koleksi }}',
                                                                                                                                '{{ addslashes($koleksi->judul_koleksi) }}'
                                                                                                                            )">

                                                    Pinjam

                                                </button>

                                            </td>

                                        </tr>

                                    @endforeach

                                @else

                                    <tr>

                                        <td colspan="4" style="text-align:center;padding:40px;">

                                            🔍 Cari judul koleksi terlebih dahulu

                                        </td>

                                    </tr>

                                @endif

                            </tbody>

                        </table>

                        <div
                            style="
                                                                                                                                                                    background:#f8fafc;
                                                                                                                                                                    border-radius:12px;
                                                                                                                                                                    padding:16px;
                                                                                                                                                                    margin-bottom:20px;
                                                                                                                                                                ">

                            <h3 style="margin-top:0;">
                                📚 Koleksi Dipilih
                            </h3>

                            <div id="selectedBooks">

                                Belum ada koleksi dipilih

                            </div>

                        </div>

                        <div id="hiddenInputs"></div>

                        <button type="submit" class="btn-simpan">

                            💾 Simpan Peminjaman

                        </button>


                    </form>

                @endif


            </div>

        </div>

    </div>

    <script>
        let koleksiDipilih =
            JSON.parse(localStorage.getItem('koleksiDipilih')) || [];

        let jumlahDipinjam = Number('{{ $jumlahDipinjam ?? 0 }}');

        let batasPinjam =
            3 - jumlahDipinjam;

        if (batasPinjam < 0) {
            batasPinjam = 0;
        }

        function tambahKoleksi(id, judul) {
            if (batasPinjam <= 0) {
                alert(
                    'Anggota sudah mencapai batas maksimal peminjaman (3 koleksi).'
                );

                return;
            }

            if (koleksiDipilih.length >= batasPinjam) {
                alert(
                    'Maksimal hanya dapat memilih ' +
                    batasPinjam +
                    ' koleksi lagi.'
                );

                return;
            }

            let sudahAda =
                koleksiDipilih.find(
                    item => item.id == id
                );

            if (sudahAda) {
                alert('Koleksi sudah dipilih');
                return;
            }

            koleksiDipilih.push({
                id: id,
                judul: judul
            });

            localStorage.setItem(
                'koleksiDipilih',
                JSON.stringify(koleksiDipilih)
            );

            renderKoleksi();
        }

        function hapusKoleksi(id) {
            koleksiDipilih =
                koleksiDipilih.filter(
                    item => item.id != id
                );

            localStorage.setItem(
                'koleksiDipilih',
                JSON.stringify(koleksiDipilih)
            );

            renderKoleksi();
        }

        function renderKoleksi() {
            let container =
                document.getElementById('selectedBooks');

            let hiddenInputs =
                document.getElementById('hiddenInputs');

            if (koleksiDipilih.length === 0) {
                container.innerHTML =
                    'Belum ada koleksi dipilih';

                hiddenInputs.innerHTML = '';

                return;
            }

            let html = '';

            let inputs = '';

            koleksiDipilih.forEach(item => {
                html += `
            <div class="selected-item">

                <span>${item.judul}</span>

                <button
                    type="button"
                    class="btn-remove"
                    onclick="hapusKoleksi('${item.id}')">

                    ✕
                </button>

            </div>
        `;

                inputs += `
            <input
                type="hidden"
                name="koleksi[]"
                value="${item.id}">
        `;
            });

            container.innerHTML = html;

            hiddenInputs.innerHTML = inputs;

            localStorage.setItem(
                'koleksiDipilih',
                JSON.stringify(koleksiDipilih)
            );
        }

        function resetPilihan() {
            localStorage.removeItem('koleksiDipilih');
        }

        @if(session('success'))

            localStorage.removeItem('koleksiDipilih');
            koleksiDipilih = [];
            renderKoleksi();

        @endif

        renderKoleksi();
    </script>

</body>

</html>