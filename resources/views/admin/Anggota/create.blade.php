<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Anggota</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
        }

        /* ===== OVERLAY ===== */
        .overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #0b9444, #0f7f3b);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* ===== CARD ===== */
        .modal-card {
            background: #fff;
            width: 500px;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .25);
        }

        /* ===== HEADER ===== */
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .modal-header h3 {
            margin: 0;
            color: #166534;
        }

        .close-btn {
            text-decoration: none;
            font-size: 24px;
            color: #555;
        }

        /* ===== LABEL ===== */
        label {
            display: block;
            margin-top: 14px;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        /* ===== INPUT ===== */
        input,
        textarea,
        select {
            width: 100%;
            padding: 11px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #16a34a;
        }

        /* ===== FOOTER ===== */
        .modal-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
        }

        /* ===== BUTTON ===== */
        .btn {
            padding: 10px 22px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-cancel {
            background: #eee;
            color: #333;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-save {
            background: #16a34a;
            color: white;
        }

        /* ===== ERROR ===== */
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
        }
    </style>
</head>

<body>

    <div class="overlay">

        <div class="modal-card">

            <!-- HEADER -->
            <div class="modal-header">

                <h3>
                    👥 Tambah Anggota
                </h3>

                <a href="/admin/anggota" class="close-btn">

                    &times;

                </a>

            </div>

            <!-- ERROR -->
            @if($errors->any())

                <div class="alert-error">

                    <ul style="margin:0; padding-left:18px;">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <!-- FORM -->
            <form action="/admin/anggota" method="POST">

                @csrf

                <!-- USERNAME -->
                <label>Username</label>

                <input type="text" name="username" required>

                <!-- PASSWORD -->
                <label>Password</label>

                <input type="password" name="password" required>

                <!-- NIS -->
                <label>NIS</label>

                <input type="text" name="nis" required>

                <!-- NAMA -->
                <label>Nama Lengkap</label>

                <input type="text" name="nama_lengkap" required>

                <!-- KELAS -->
                <label>Kelas Anggota</label>

                <input type="text" name="kelas_anggota" required>

                <!-- JK -->
                <label>Jenis Kelamin</label>

                <select name="jenis_kelamin" required>

                    <option value="">
                        -- Pilih --
                    </option>

                    <option value="L">
                        Laki-laki
                    </option>

                    <option value="P">
                        Perempuan
                    </option>

                </select>

                <!-- ALAMAT -->
                <label>Alamat</label>

                <textarea name="alamat" required></textarea>

                <!-- FOOTER -->
                <div class="modal-footer">

                    <a href="/admin/anggota" class="btn btn-cancel">

                        Batal

                    </a>

                    <button type="submit" class="btn btn-save">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</body>

</html>