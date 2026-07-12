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
                <input type="text" name="username" placeholder="Masukkan username">

                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password">

                <button type="submit">Masuk</button>
            </form>

        </div>
    </div>

</body>

</html>