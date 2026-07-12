<div class="navbar">

    <a href="{{ route('landing') }}" class="logo">
        <img src="{{ asset('images/logo.png') }}">
        <h2>SIMPER</h2>
    </a>

    <div class="menu">

        <a href="{{ route('landing') }}#katalog" class="nav-link
   {{ request()->routeIs('landing') ? 'landing-link' : '' }}">
            Katalog
        </a>

        <a href="{{ route('menu.peminjaman') }}" class="nav-link
{{ request()->routeIs('menu.peminjaman') || request()->routeIs('anggota.peminjaman') ? 'active' : '' }}">
            Peminjaman
        </a>

        <a href="#panduan" class="nav-link">
            Panduan
        </a>

        <a href="{{ route('anggota.profil') }}"
            class="nav-link {{ request()->routeIs('anggota.profil') ? 'active' : '' }}">
            Profil Saya
        </a>


    </div>

    @if(session('role') == 'anggota')

        <div class="user-info">

            👋 Halo, {{ session('nama_lengkap') }}

            <a href="{{ route('logout') }}" class="logout-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                Logout

            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">

                @csrf

            </form>

        </div>

    @else

        <a href="{{ route('login') }}" class="btn-login">
            Masuk
        </a>

    @endif

</div>