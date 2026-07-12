<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Peminjaman</title>

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
        }

        .logo-text p {
            margin: 2px 0;
            font-size: 12px;
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
            padding: 24px 30px;
            background: white;
        }

        .badge.ditolak {
            background: #fee2e2;
            color: #dc2626;
        }

        /* ===== CARD ===== */
        .card {
            background: #fff;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .08);
        }

        /* ===== INFO GRID ===== */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .info-box {
            background: #f9fafb;
            padding: 16px;
            border-radius: 10px;
        }

        .info-box label {
            display: block;
            font-size: 13px;
            color: #666;
            margin-bottom: 6px;
        }

        .info-box strong {
            color: #111827;
        }

        /* ===== STATUS ===== */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: bold;
        }

        .dipinjam {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .dikembalikan {
            background: #dcfce7;
            color: #166534;
        }

        .terlambat {
            background: #fee2e2;
            color: #991b1b;
        }

        .menunggu {
            background: #fef3c7;
            color: #92400e;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
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

        /* ===== BUTTON ===== */
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            background: #16a34a;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: bold;
        }

        .denda {
            color: #dc2626;
            font-weight: bold;
        }

        .modal {

            display: none;

            position: fixed;

            left: 0;
            top: 0;

            width: 100%;
            height: 100%;

            background: rgba(0, 0, 0, .4);

            justify-content: center;

            align-items: center;

            z-index: 9999;

        }

        .modal-content {

            background: white;

            padding: 25px;

            width: 400px;

            border-radius: 12px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, .25);

        }

        .modal-content h3 {

            margin-top: 0;

            margin-bottom: 20px;

        }

        .modal-content input {

            width: 100%;

            padding: 12px;

            margin-top: 10px;

            margin-bottom: 20px;

            border: 1px solid #ccc;

            border-radius: 8px;

        }

        .modal-button {

            display: flex;

            justify-content: flex-end;

            gap: 10px;

        }

        .modal-button button {

            padding: 10px 18px;

            border: none;

            border-radius: 8px;

            cursor: pointer;

        }

        .modal-button button:first-child {

            background: #94a3b8;

            color: white;

        }

        .modal-button button:last-child {

            background: #16a34a;

            color: white;

        }

        .action-btn {
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            width: 120px;
            cursor: pointer;
            color: white;
            font-size: 13px;
            font-weight: 600;
            transition: .2s;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .btn-kembalikan {
            background: #16a34a;
        }

        .btn-kembalikan:hover {
            background: #15803d;
        }

        .btn-rusak {
            background: #f59e0b;
        }

        .btn-rusak:hover {
            background: #d97706;
        }

        .btn-hilang {
            background: #dc2626;
        }

        .btn-hilang:hover {
            background: #b91c1c;
        }
    </style>
</head>

<body>

    <div class="wrapper">

        <!-- SIDEBAR -->
        <div class="sidebar">

            <div class="logo-box">

                <img src="{{ asset('images/logo.png') }}">

                <div class="logo-text">

                    <h3>SIMPER</h3>

                    <p>Sistem Informasi Perpustakaan</p>

                    <span>MTs Islamiyah Banat Senori</span>

                </div>

            </div>

            <div class="menu">

                <a href="/admin/dashboard">
                    🏠 Dashboard
                </a>

                <a href="/admin/peminjaman" class="active">

                    📦 Peminjaman

                </a>

                <a href="/admin/koleksi">
                    📚 Koleksi
                </a>

                <a href="/admin/anggota">
                    👥 Anggota
                </a>

            </div>

        </div>

        <!-- CONTENT -->
        <div class="content">

            @include('partials.navbar-admin')

            <a href="/admin/peminjaman" class="back-btn">

                ⬅ Kembali

            </a>

            <div class="card">

                <h2>
                    📄 Detail Peminjaman
                </h2>

                <!-- INFO -->
                <div class="info-grid">

                    <div class="info-box">

                        <label>Nama Anggota</label>

                        <strong>
                            {{ $peminjaman->anggota->nama_lengkap }}
                        </strong>

                    </div>

                    <div class="info-box">

                        <label>NIS</label>

                        <strong>
                            {{ $peminjaman->anggota->nis }}
                        </strong>

                    </div>

                    <div class="info-box">

                        <label>Tanggal Pinjam</label>

                        <strong>
                            {{ $peminjaman->tanggal_pinjam }}
                        </strong>

                    </div>

                    <div class="info-box">

                        <label>Tanggal Kembali</label>

                        <strong>
                            {{ $peminjaman->tanggal_kembali }}
                        </strong>

                    </div>

                    <div class="info-box">

                        <label>Status Peminjaman</label>

                        @php
                            $statusClass = match ($peminjaman->status_peminjaman) {

                                'proses' => 'menunggu',
                                'dipinjam' => 'dipinjam',
                                'terlambat' => 'terlambat',
                                'selesai' => 'dikembalikan',
                                'ditolak' => 'ditolak',

                                default => 'menunggu'
                            };
                        @endphp

                        <span class="badge {{ $statusClass }}">

                            {{ ucfirst($peminjaman->status_peminjaman) }}

                        </span>

                    </div>

                </div>

                {{-- ACTION BUTTON --}}

                @if($peminjaman->status_peminjaman == 'menunggu')

                    <form action="/admin/peminjaman/{{ $peminjaman->id_peminjaman }}/approve" method="POST">

                        @csrf
                        @method('PUT')

                        <button type="submit" onclick="return confirm('Setujui peminjaman ini?')"
                            style="
                                                                                                                                                        background:#16a34a;
                                                                                                                                                        color:white;
                                                                                                                                                        border:none;
                                                                                                                                                        padding:12px 20px;
                                                                                                                                                        border-radius:8px;
                                                                                                                                                        cursor:pointer;
                                                                                                                                                        font-weight:bold;
                                                                                                                                                    ">
                            ✅ Setujui Peminjaman
                        </button>

                    </form>

                @endif


                @if(
                        $peminjaman->status_peminjaman == 'dipinjam'
                        || $peminjaman->status_peminjaman == 'terlambat'
                    )

                    <form action="/admin/peminjaman/{{ $peminjaman->id_peminjaman }}/kembalikan" method="POST">

                        @csrf
                        @method('PUT')

                        <button type="submit" class="action-btn btn-kembalikan"
                            onclick="return confirm('Tandai buku ini sebagai dikembalikan?')">

                            ✅ Kembalikan

                        </button>

                    </form>

                @endif

            </div>

            <!-- TABLE -->
            <h3>
                📚 Daftar Koleksi Dipinjam
            </h3>

            <table>

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Cover</th>

                        <th>Judul Koleksi</th>

                        <th>Penulis</th>

                        <th>Jumlah</th>

                        <th>Status Item</th>

                        <th>Denda</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($peminjaman->detail as $i => $detail)

                        <tr>

                            <td>
                                {{ $i + 1 }}
                            </td>

                            <td>

                                @if($detail->koleksi->gambar)

                                    <img src="{{ asset('uploads/koleksi/' . $detail->koleksi->gambar) }}"
                                        style="
                                                                                                                                                                                                                                                                    width:70px;
                                                                                                                                                                                                                                                                    height:90px;
                                                                                                                                                                                                                                                                    object-fit:cover;
                                                                                                                                                                                                                                                                    border-radius:8px;
                                                                                                                                                                                                                                                                ">

                                @else

                                    <img src="{{ asset('images/no-cover.png') }}"
                                        style="
                                                                                                                                                                                                                                                                    width:70px;
                                                                                                                                                                                                                                                                    height:90px;
                                                                                                                                                                                                                                                                    object-fit:cover;
                                                                                                                                                                                                                                                                    border-radius:8px;
                                                                                                                                                                                                                                                                ">

                                @endif

                            </td>

                            <td>
                                {{ $detail->koleksi->judul_koleksi }}
                            </td>

                            <td>
                                {{ $detail->koleksi->penulis }}
                            </td>

                            <td>
                                {{ $detail->jumlah }}
                            </td>

                            <td>

                                <span class="badge {{ $detail->status_item }}">

                                    {{ ucfirst($detail->status_item) }}

                                </span>

                            </td>

                            <td class="denda">

                                Rp {{ number_format($detail->jumlah_denda) }}

                            </td>

                            <td>

                                @if($detail->status_item == 'dipinjam')

                                    <div
                                        style="
                                                                                                                                                                                                                display:flex;
                                                                                                                                                                                                                flex-direction:column;
                                                                                                                                                                                                                gap:8px;
                                                                                                                                                                                                            ">

                                        {{-- KEMBALIKAN --}}
                                        <form action="{{ route('admin.detail.kembalikan', $detail->id_detailp) }}"
                                            method="POST">

                                            @csrf
                                            @method('PUT')

                                            <button type="submit"
                                                onclick="return confirm('Tandai buku ini sebagai dikembalikan?')"
                                                style="
                                                                                                                                                                                                                            background:#16a34a;
                                                                                                                                                                                                                            color:white;
                                                                                                                                                                                                                            border:none;
                                                                                                                                                                                                                            padding:8px 12px;
                                                                                                                                                                                                                            border-radius:6px;
                                                                                                                                                                                                                            cursor:pointer;
                                                                                                                                                                                                                            font-size:13px;
                                                                                                                                                                                                                            width:120px;
                                                                                                                                                                                                                        ">

                                                ✅ Kembalikan

                                            </button>

                                        </form>

                                        {{-- RUSAK --}}
                                        <form action="{{ route('admin.detail.rusak', $detail->id_detailp) }}" method="POST">

                                            @csrf
                                            @method('PUT')

                                            <button type="button" class="action-btn btn-rusak"
                                                onclick="openRusakModal({{ $detail->id_detailp }})">

                                                ⚠️ Rusak

                                            </button>

                                        </form>

                                        {{-- HILANG --}}
                                        <form action="{{ route('admin.detail.hilang', $detail->id_detailp) }}" method="POST">

                                            @csrf
                                            @method('PUT')

                                            <button type="button" class="action-btn btn-hilang"
                                                onclick="openHilangModal({{ $detail->id_detailp }})">

                                                ❌ Hilang

                                            </button>

                                        </form>

                                    </div>

                                @else

                                    <span
                                        style="
                                                                                                                                                                                                                color:#64748b;
                                                                                                                                                                                                                font-size:13px;
                                                                                                                                                                                                            ">
                                        Tidak ada aksi
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" style="text-align:center;">

                                Tidak ada detail peminjaman

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    </div>

    <!-- MODAL INPUT DENDA -->

    <div id="modalDenda" class="modal">

        <div class="modal-content">

            <h3 id="judulModal">Input Denda</h3>

            <form id="formDenda" method="POST">

                @csrf
                @method('PUT')

                <label>Jumlah Denda</label>

                <input type="number" name="jumlah_denda" min="0" required>

                <div class="modal-button">

                    <button type="button" onclick="closeModal()">

                        Batal

                    </button>

                    <button type="submit">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        function openRusakModal(id) {

            document.getElementById("judulModal").innerHTML = "Input Denda Buku Rusak";

            document.getElementById("formDenda").action =
                "/admin/detail-peminjaman/" + id + "/rusak";

            document.getElementById("modalDenda").style.display = "flex";

        }

        function openHilangModal(id) {

            document.getElementById("judulModal").innerHTML = "Input Denda Buku Hilang";

            document.getElementById("formDenda").action =
                "/admin/detail-peminjaman/" + id + "/hilang";

            document.getElementById("modalDenda").style.display = "flex";

        }

        function closeModal() {

            document.getElementById("modalDenda").style.display = "none";

        }
    </script>

</body>

</html>