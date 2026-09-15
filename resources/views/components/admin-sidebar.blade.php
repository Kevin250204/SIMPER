<style>
.admin-sidebar {

    width: 300px;
    height: 100vh;

    background: linear-gradient(180deg,
            #0b9444,
            #0a6c34);

    color: white;

    position: fixed;
    top: 0;
    left: 0;

    display: flex;
    flex-direction: column;

    box-shadow:
        5px 0 20px rgba(0, 0, 0, .08);

    overflow: hidden;

    z-index: 1000;
}

/* =====================
   LOGO
===================== */

.sidebar-logo {
    padding: 24px 20px;

    border-bottom:
        1px solid rgba(255, 255, 255, .15);

    display: flex;
    gap: 14px;
    align-items: center;
}

.sidebar-logo img {
    width: 58px;
    height: 58px;
    object-fit: contain;
}

.logo-title {
    font-size: 26px;
    font-weight: 700;
}

.logo-subtitle {
    font-size: 12px;
    line-height: 1.5;
    opacity: .9;
}

/* =====================
   MENU
===================== */

.sidebar-menu {
    padding: 20px 15px;
}

.sidebar-menu a {

    display: flex;
    align-items: center;
    gap: 12px;

    color: white;
    text-decoration: none;

    padding: 14px 16px;
    border-radius: 14px;

    margin-bottom: 8px;

    transition: .25s;
}

.sidebar-menu a:hover {

    background:
        rgba(255, 255, 255, .18);

    transform: translateX(4px);
}

.sidebar-menu a.active {

    background:
        rgba(255, 255, 255, .20);

    font-weight: 700;
}

/* =====================
   ICON
===================== */

.menu-icon {
    width: 22px;
    text-align: center;
}

/* =====================
   FOOTER
===================== */

.sidebar-footer {

    margin-top: auto;

    padding: 20px;

    border-top:
        1px solid rgba(255, 255, 255, .15);

    font-size: 12px;

    opacity: .8;
}

@media(max-width:900px) {

    .admin-sidebar {

        width: 85px;
    }

    .logo-content,
    .menu-text,
    .sidebar-footer {

        display: none;
    }

    .sidebar-logo {

        justify-content: center;
    }

    .sidebar-menu a {

        justify-content: center;
    }
}
</style>

<div class="admin-sidebar">

    <div class="sidebar-logo">

        <img src="{{ asset('images/logo.png') }}">

        <div class="logo-content">

            <div class="logo-title">
                SIMPER
            </div>

            <div class="logo-subtitle">

                Sistem Informasi
                Perpustakaan

                <br>

                MTs Islamiyah
                Banat Senori

            </div>

        </div>

    </div>

    <div class="sidebar-menu">

        <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <span class="menu-icon">📊</span>
            <span class="menu-text">Dashboard</span>
        </a>

        <a href="/admin/peminjaman" class="{{ request()->is('admin/peminjaman*') ? 'active' : '' }}">
            <span class="menu-icon">📦</span>
            <span class="menu-text">Peminjaman</span>
        </a>

        <a href="/admin/koleksi" class="{{ request()->is('admin/koleksi*') ? 'active' : '' }}">
            <span class="menu-icon">📚</span>
            <span class="menu-text">Koleksi</span>
        </a>

        <a href="/admin/jenis-koleksi" class="{{ request()->is('admin/jenis-koleksi*') ? 'active' : '' }}">
            <span class="menu-icon">📖</span>
            <span class="menu-text">Jenis Koleksi</span>
        </a>

        <a href="/admin/kategori-koleksi" class="{{ request()->is('admin/kategori-koleksi*') ? 'active' : '' }}">
            <span class="menu-icon">🏷️</span>
            <span class="menu-text">Kategori Koleksi</span>
        </a>

        <a href="/admin/anggota" class="{{ request()->is('admin/anggota*') ? 'active' : '' }}">
            <span class="menu-icon">👥</span>
            <span class="menu-text">Anggota</span>
        </a>

        <a href="/admin/laporan" class="{{ request()->is('admin/laporan*') ? 'active' : '' }}">
            <span class="menu-icon">📑</span>
            <span class="menu-text">Laporan</span>
        </a>

    </div>

</div>