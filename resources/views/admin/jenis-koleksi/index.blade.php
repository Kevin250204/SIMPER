<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Manajemen Jenis Koleksi</title>

    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">

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
        padding: 24px 30px;
        background: white;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 10px;
    }

    .btn-add {
        background: #16a34a;
        color: white;
        border: none;
        padding: 10px 16px;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        font-weight: 600;
    }

    .btn-stock {
        background: #2563eb;
    }

    /* ===== ALERT ===== */
    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 16px;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 16px;
    }

    /* ===== SEARCH ===== */
    .search-box {
        display: flex;
        gap: 8px;
        margin-bottom: 18px;
    }

    .search-box input {
        padding: 10px 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
        width: 300px;
    }

    .search-box button {
        background: #198754;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 10px 14px;
        cursor: pointer;
    }

    .reset-btn {
        background: #e5e7eb;
        color: #333;
        text-decoration: none;
        border-radius: 6px;
        padding: 10px 14px;
    }

    /* ===== TABLE ===== */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
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
        vertical-align: middle;
    }

    th {
        color: #166534;
    }

    tbody tr:hover {
        background: #f9fafb;
    }

    /* ===== COVER ===== */
    .cover {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .no-cover {
        width: 60px;
        height: 80px;
        background: #f3f4f6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: #666;
        text-align: center;
    }

    /* ===== BADGE ===== */
    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: bold;
    }

    .badge-jenis {
        background: #e0f2fe;
        color: #0369a1;
    }

    .stok-banyak {
        background: #dcfce7;
        color: #166534;
    }

    .stok-sedikit {
        background: #fef3c7;
        color: #92400e;
    }

    .stok-habis {
        background: #fee2e2;
        color: #991b1b;
    }

    /* ===== AKSI ===== */
    .aksi {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .btn-detail,
    .btn-edit,
    .btn-delete {
        padding: 7px 10px;
        border-radius: 6px;
        color: white;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 12px;
    }

    .btn-detail {
        background: #2563eb;
    }

    .btn-edit {
        background: #16a34a;
    }

    .btn-delete {
        background: #dc2626;
    }

    .content {
        flex: 1;
        margin-left: 300px;
        padding: 24px;
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

            @if(session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
            @endif

            <div class="header">

                <h2 style="flex:1;">

                </h2>

                <a href="{{ route('jenis-koleksi.create') }}" class="btn-add">
                    + Tambah Jenis Koleksi
                </a>

            </div>

            <!-- SEARCH -->
            <form method="GET" action="{{ route('jenis-koleksi.index') }}" class="search-box">

                <input type="text" name="search" placeholder="Cari jenis koleksi..." value="{{ request('search') }}">

                <button type="submit">
                    Cari
                </button>

                @if(request('search'))

                <a href="{{ route('jenis-koleksi.index') }}" class="reset-btn">
                    Reset
                </a>

                @endif

            </form>

            <!-- TABLE -->
            <table>

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Nama Jenis Koleksi</th>

                        <th width="170">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($jenis as $item)

                    <tr>

                        <td>

                            {{ ($jenis->currentPage() - 1) * $jenis->perPage() + $loop->iteration }}

                        </td>

                        <td>

                            {{ $item->nama_jenis }}

                        </td>

                        <td>

                            <div class="aksi">

                                <a href="{{ route('jenis-koleksi.edit', $item->id_jenis) }}" class="btn-edit">

                                    Edit

                                </a>

                                <form action="{{ route('jenis-koleksi.destroy', $item->id_jenis) }}" method="POST">

                                    @csrf

                                    @method('DELETE')

                                    <button class="btn-delete" onclick="return confirm('Hapus jenis koleksi?')">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="3">

                            Belum ada data jenis koleksi.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

            <x-pagination :data="$jenis" />

        </div>

    </div>

</body>

</html>