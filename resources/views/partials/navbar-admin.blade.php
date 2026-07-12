<style>
    .top-navbar {
        position: sticky;
        top: 0;
        z-index: 100;

        background: #fff;

        display: flex;
        justify-content: space-between;
        align-items: center;

        padding: 18px 30px;

        margin:
            -30px -30px 30px -30px;

        box-shadow: 0 2px 15px rgba(0, 0, 0, .08);
    }

    .navbar-left {
        display: flex;
        flex-direction: column;
    }

    .navbar-title {
        font-size: 22px;
        font-weight: 700;
        color: #166534;
    }

    .navbar-subtitle {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
    }

    .navbar-right {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .admin-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .admin-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;

        display: flex;
        justify-content: center;
        align-items: center;

        background: linear-gradient(180deg,
                #0b9444,
                #0a6c34);

        color: white;
        font-size: 20px;
        font-weight: bold;
    }

    .admin-name {
        font-size: 15px;
        font-weight: 700;
        color: #166534;
    }

    .admin-role {
        font-size: 12px;
        color: #64748b;
    }

    .logout-btn {
        background: #dc2626;
        color: white;

        border: none;
        border-radius: 10px;

        padding: 10px 18px;

        font-weight: 600;
        cursor: pointer;

        transition: .25s;
    }

    .logout-btn:hover {
        background: #b91c1c;
        transform: translateY(-2px);
    }

    @media(max-width:768px) {

        .top-navbar {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .navbar-right {
            width: 100%;
            justify-content: space-between;
        }

    }

    .admin-dropdown {
        position: relative;
    }

    .admin-info {
        cursor: pointer;
    }

    .dropdown-menu {

        position: absolute;
        top: 60px;
        right: 0;

        background: white;

        min-width: 220px;

        border-radius: 12px;

        box-shadow: 0 10px 25px rgba(0, 0, 0, .15);

        display: none;

        overflow: hidden;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-menu a {

        display: block;

        padding: 14px 18px;

        text-decoration: none;

        color: #166534;
    }

    .dropdown-menu a:hover {
        background: #f1f5f9;
    }

    .dropdown-menu button {

        width: 100%;

        border: none;

        background: none;

        text-align: left;

        padding: 14px 18px;

        cursor: pointer;

        color: #dc2626;
    }
</style>

<div class="top-navbar">

    <div class="navbar-left">

        @php

            $title = 'Dashboard Admin';
            $subtitle = 'Ringkasan aktivitas perpustakaan';

            if (request()->is('admin/peminjaman*')) {
                $title = 'Manajemen Peminjaman';
                $subtitle = 'Kelola approval dan pengembalian koleksi perpustakaan';
            } elseif (request()->is('admin/koleksi*')) {
                $title = 'Manajemen Koleksi';
                $subtitle = 'Kelola seluruh data koleksi perpustakaan';
            } elseif (request()->is('admin/anggota*')) {
                $title = 'Manajemen Anggota';
                $subtitle = 'Kelola data anggota perpustakaan';
            }

        @endphp

        <div class="navbar-title">
            {{ $title }}
        </div>

        <div class="navbar-subtitle">
            {{ $subtitle }}
        </div>

    </div>

    <div class="navbar-right">

        <div class="admin-dropdown">

            <div class="admin-info" onclick="toggleMenu()">

                <div class="admin-avatar">
                    👤
                </div>

                <div>

                    <div class="admin-name">
                        {{ Auth::user()->name ?? 'Admin' }}
                    </div>

                    <div class="admin-role">
                        Administrator Perpustakaan
                    </div>

                </div>

            </div>

            <div id="adminMenu" class="dropdown-menu">

                <a href="{{ route('admin.password.form') }}">
                    🔑 Ubah Password
                </a>

                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button type="submit">
                        🚪 Logout
                    </button>

                </form>

            </div>

        </div>

    </div>
    <script>
        function toggleMenu() {
            document
                .getElementById('adminMenu')
                .classList
                .toggle('show');
        }

        window.onclick = function (event) {
            if (
                !event.target.closest('.admin-dropdown')
            ) {
                document
                    .getElementById('adminMenu')
                    .classList
                    .remove('show');
            }
        }
    </script>
</div>