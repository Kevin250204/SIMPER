<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>Profil Saya</title>

    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    <link rel="stylesheet" href="{{ asset('css/profil.css') }}">

    @include('components.navbar')

</head>

<body>

    <div class="profil-container">

        <h1>Profil Saya</h1>

        <p>

            Kelola informasi denda perpustakaan
            dan keamanan kata sandi Anda.

        </p>

        <div class="profil-grid"></div>

        <div class="card">

            <h2>

                💳 Informasi Denda

            </h2>

            <div class="denda-box">

                <div>

                    <p>Total Denda Dibayar</p>

                    <h3>

                        Rp {{ number_format(abs($totalDibayar), 0, ',', '.') }}

                    </h3>

                </div>

                <span class="badge selesai">

                    Selesai

                </span>

            </div>

            <div class="denda-box danger">

                <div>

                    <p>Denda Belum Dibayar</p>

                    <h3>

                        Rp {{ number_format($belumDibayar, 0, ',', '.') }}

                    </h3>

                </div>

                <span class="badge danger">

                    Tunggakan

                </span>

            </div>

        </div>

        <div class="card" id="ubah-password">

            <h2>

                🔒 Ubah Kata Sandi

            </h2>

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

            <form action="{{ route('anggota.profil.password') }}" method="POST">

                @csrf

                <label>Password Lama</label>

                <input type="password" name="password_lama" placeholder="Masukkan password lama"
                    autocomplete="current-password" class="@error('password_lama') input-error @enderror">

                @error('password_lama')
                    <small class="text-error">{{ $message }}</small>
                @enderror

                <label>Password Baru</label>

                <input type="password" name="password_baru" placeholder="Masukkan password baru"
                    autocomplete="new-password" class="@error('password_baru') input-error @enderror">

                @error('password_baru')
                    <small class="text-error">{{ $message }}</small>
                @enderror

                <label>Konfirmasi Password Baru</label>

                <input type="password" name="password_baru_confirmation" placeholder="Konfirmasi password baru"
                    autocomplete="new-password" class="@error('password_baru') input-error @enderror">

                <button type="submit">

                    Simpan Kata Sandi Baru

                </button>

            </form>

        </div>

    </div>

    </div>

</body>