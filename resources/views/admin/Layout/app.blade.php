<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <link rel="stylesheet" href="/css/admin.css">
</head>

<body>
    <!-- gak kepake nanti di hapus -->
    <div class="wrapper">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="/images/logo.png" alt="Logo">
                <h3>SIMPER</h3>
                <p>Sistem Informasi Perpustakaan<br>MA Islamiyah Senori</p>
            </div>

            <nav class="sidebar-menu">
                <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    🏠 <span>Dasbor</span>
                </a>

                <a href="/admin/peminjaman" class="{{ request()->is('admin/peminjaman*') ? 'active' : '' }}">
                    📦 <span>Peminjaman</span>
                </a>

                <a href="/admin/buku" class="{{ request()->is('admin/buku*') ? 'active' : '' }}">
                    📚 <span>Buku</span>
                </a>

                <a href="/admin/siswa" class="{{ request()->is('admin/siswa*') ? 'active' : '' }}">
                    👥 <span>Siswa</span>
                </a>
            </nav>
        </aside>

        <!-- CONTENT -->
        <main class="content">
            @yield('content')
        </main>

    </div>

</body>

</html>