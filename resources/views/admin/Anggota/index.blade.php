<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Manajemen Anggota</title>

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
            opacity: 0.9;
        }

        .logo-text span {
            font-size: 11px;
            opacity: 0.85;
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

        .header h2 {
            margin: 0;
        }

        /* ===== BUTTON ===== */
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

        /* ===== SEARCH ===== */
        .search-box {
            display: flex;
            gap: 8px;
            margin-bottom: 18px;
        }

        .search-box input {
            width: 300px;
            padding: 10px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
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
        }

        thead {
            background: #e9f7ef;
        }

        th,
        td {
            padding: 12px;
            font-size: 14px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            color: #166534;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        /* ===== ACTION ===== */
        .aksi {
            display: flex;
            gap: 10px;
        }

        .btn-icon {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }

        .btn-edit {
            color: #16a34a;
        }

        .btn-delete {
            color: #dc2626;
        }

        .btn-status {
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-nonaktif {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-nonaktif:hover {
            background: #fecaca;
        }

        .btn-aktif {
            background: #dcfce7;
            color: #166534;
        }

        .btn-aktif:hover {
            background: #bbf7d0;
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
            color: #b91c1c;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            border-left: 4px solid #dc2626;
        }

        .content {
            flex: 1;
            margin-left: 300px;
            padding: 24px;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-active {
            background: #dcfce7;
            color: #166534;
        }

        .badge-nonaktif {
            background: #fee2e2;
            color: #dc2626;
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

            <!-- HEADER -->
            <div class="header">

                <h2>

                </h2>

                <a href="/admin/anggota/create" class="btn-add">

                    + Tambah Anggota

                </a>

            </div>

            <!-- SEARCH -->
            <form action="/admin/anggota" method="GET" class="search-box">

                <input type="text" name="search" placeholder="Cari anggota..." value="{{ request('search') }}">

                <button type="submit">

                    Cari

                </button>

                @if(request('search'))

                    <a href="/admin/anggota" class="reset-btn">

                        Reset

                    </a>

                @endif

            </form>

            <!-- TABLE -->
            <table>

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Username</th>

                        <th>NIS</th>

                        <th>Nama Lengkap</th>

                        <th>Kelas</th>

                        <th>JK</th>

                        <th>Alamat</th>

                        <th>Status</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($anggotas as $i => $anggota)

                        <tr>

                            <td>
                                {{ ($anggotas->currentPage() - 1) * $anggotas->perPage() + $loop->iteration }}
                            </td>

                            <td>
                                {{ $anggota->user->username }}
                            </td>

                            <td>{{ $anggota->nis }}</td>

                            <td>{{ $anggota->nama_lengkap }}</td>

                            <td>{{ $anggota->kelas_anggota }}</td>

                            <td>{{ $anggota->jenis_kelamin }}</td>

                            <td>{{ $anggota->alamat }}</td>

                            <td>

                                @if($anggota->user->status_aktif)

                                    <span class="badge badge-active">
                                        Aktif
                                    </span>

                                @else

                                    <span class="badge badge-nonaktif">
                                        Nonaktif
                                    </span>

                                @endif

                            </td>

                            <td class="aksi">

                                <a href="/admin/anggota/{{ $anggota->id_anggota }}/edit" class="btn-icon btn-edit">

                                    ✏️

                                </a>

                                <form action="/admin/anggota/{{ $anggota->id_anggota }}" method="POST" @if(
                                        $anggota->
                                            user->status_aktif
                                    )
                                onsubmit="return confirm('Yakin ingin menonaktifkan akun anggota ini?')" @else
                                    onsubmit="return confirm('Yakin ingin mengaktifkan kembali akun anggota ini?')" @endif>

                                    @csrf
                                    @method('DELETE')

                                    @if($anggota->user->status_aktif)

                                        <button type="submit" class="btn-status btn-nonaktif">

                                            🔒 Nonaktifkan

                                        </button>

                                    @else

                                        <button type="submit" class="btn-status btn-aktif">

                                            🔓 Aktifkan

                                        </button>

                                    @endif

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" style="text-align:center;">

                                Belum ada data anggota

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            <x-pagination :data="$anggotas" />

        </div>

    </div>

</body>

</html>