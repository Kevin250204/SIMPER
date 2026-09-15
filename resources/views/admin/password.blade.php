<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: #16a34a;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            width: 100%;
            max-width: 500px;
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .15);
        }

        .logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo h2 {
            color: #065f46;
            margin-top: 10px;
        }

        .logo p {
            color: #666;
            margin-top: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #16a34a;
        }

        .btn {
            width: 100%;
            background: #16a34a;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            font-size: 15px;
        }

        .btn:hover {
            background: #15803d;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .back-btn {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #16a34a;
            text-decoration: none;
            font-weight: 600;
        }

        .back-btn:hover {
            text-decoration: underline;
        }

        .text-error {

            display: block;

            margin-top: 6px;

            color: #dc2626;

            font-size: 13px;

        }

        .input-error {

            border: 1px solid #dc2626 !important;

        }
    </style>
</head>

<body>

    <div class="card">

        <div class="logo">
            <h2>🔐 Ubah Password Admin</h2>
            <p>Sistem Informasi Perpustakaan</p>
        </div>

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="error">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.password.update') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Password Lama</label>
                <input type="password" name="password_lama" placeholder="Masukkan password lama"
                    autocomplete="current-password" class="@error('password_lama') input-error @enderror">

                @error('password_lama')

                    <small class="text-error">

                        {{ $message }}

                    </small>

                @enderror
            </div>

            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password_baru" placeholder="Masukkan password baru"
                    autocomplete="new-password" class="@error('password_baru') input-error @enderror">

                @error('password_baru')

                    <small class="text-error">

                        {{ $message }}

                    </small>

                @enderror
            </div>

            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="password_baru_confirmation" placeholder="Konfirmasi password baru"
                    autocomplete="new-password">
            </div>

            <button type="submit" class="btn">
                Simpan Password Baru
            </button>
        </form>

        <a href="{{ route('admin.dashboard') }}" class="back-btn">
            ← Kembali ke Dashboard
        </a>

    </div>

</body>

</html>