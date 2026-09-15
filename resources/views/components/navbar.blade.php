<div class="simper-navbar">

    <!-- Logo -->
    <a href="{{ route('landing') }}" class="simper-logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo SIMPER">
        <h2>SIMPER</h2>
    </a>

    <!-- Menu -->
    <div class="simper-menu">

        <a href="{{ route('landing') }}#katalog"
            class="simper-nav-link {{ request()->routeIs('landing') ? 'landing-link' : '' }}">
            Katalog
        </a>

        <a href="{{ route('menu.peminjaman') }}"
            class="simper-nav-link {{ request()->routeIs('menu.peminjaman') || request()->routeIs('anggota.peminjaman') ? 'active' : '' }}">
            Peminjaman
        </a>

        {{-- Jika nanti ingin ditampilkan --}}
        {{--
        <a href="#panduan" class="simper-nav-link">
            Panduan
        </a>
        --}}

        <a href="{{ route('anggota.profil') }}"
            class="simper-nav-link {{ request()->routeIs('anggota.profil') ? 'active' : '' }}">
            Profil Saya
        </a>

    </div>

    <!-- User -->
    @if(session('role') == 'anggota')

        <div class="simper-user-info">

            <span class="simper-user-name">
                👋 Halo, {{ session('nama_lengkap') }}
            </span>

            <a href="{{ route('logout') }}" class="simper-logout-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>

        </div>

    @else

        <a href="{{ route('login') }}" class="simper-btn-login">
            Masuk
        </a>

    @endif

</div>