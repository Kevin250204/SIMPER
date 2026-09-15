<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login | SIMPER</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <div class="login-container">
        <div class="login-card">

            <img src="{{ asset('images/logo.png') }}" class="logo">

            <h2>MTs Islamiyah Banat</h2>
            <p>Senori - Tuban</p>

            {{-- ERROR LOGIN --}}





            <form method="POST" action="/login">
                @csrf

                @if(session('error'))
                    <div class="alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" value="{{ old('username') }}"
                    class="@error('username') input-error @enderror">

                @error('username')
                    <small class="text-error">{{ $message }}</small>
                @enderror

                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password"
                    class="@error('password') input-error @enderror">

                @error('password')
                    <small class="text-error">{{ $message }}</small>
                @enderror

                <button type="submit">Masuk</button>

                <a href="{{ route('landing') }}" class="btn-back">
                    ← Kembali
                </a>
            </form>

        </div>
    </div>

</body>

</html>