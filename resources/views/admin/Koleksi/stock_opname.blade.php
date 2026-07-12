<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Stock Opname Koleksi</title>

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
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    /* ===== CARD ===== */
    .card {
        background: #fff;
        width: 480px;
        border-radius: 14px;
        padding: 26px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, .25);
    }

    /* ===== TITLE ===== */
    h3 {
        margin-top: 0;
        margin-bottom: 20px;
        color: #166534;
    }

    /* ===== LABEL ===== */
    label {
        display: block;
        margin-top: 14px;
        margin-bottom: 6px;
        font-weight: bold;
        font-size: 14px;
        color: #333;
    }

    /* ===== INPUT ===== */
    input,
    select,
    textarea {
        width: 100%;
        padding: 11px;
        border-radius: 8px;
        border: 1px solid #ccc;
        outline: none;
    }

    textarea {
        resize: none;
        height: 90px;
    }

    input:focus,
    select:focus,
    textarea:focus {
        border-color: #16a34a;
    }

    /* ===== INFO ===== */
    .info-box {
        margin-top: 12px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        padding: 12px;
        border-radius: 8px;
        color: #166534;
        font-size: 14px;
    }

    /* ===== FOOTER ===== */
    .footer {
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
        text-decoration: none;
    }

    .save {
        background: #16a34a;
        color: white;
    }

    .cancel {
        background: #eee;
        color: #333;
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

        <div class="card">

            <!-- TITLE -->
            <h3>
                📦 Stock Opname Koleksi
            </h3>

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
            <form method="POST" action="/admin/stock-opname">

                @csrf

                <!-- KOLEKSI -->
                <label>Pilih Koleksi</label>

                <select name="id_koleksi" required>

                    <option value="">
                        -- Pilih Koleksi --
                    </option>

                    @foreach($koleksis as $koleksi)

                    <option value="{{ $koleksi->id_koleksi }}">

                        {{ $koleksi->judul_koleksi }}
                        | ISBN:
                        {{ $koleksi->isbn }}
                        | Stok:
                        {{ $koleksi->stok }}

                    </option>

                    @endforeach

                </select>

                <!-- STOK -->
                <label>Stok Fisik</label>

                <input type="number" name="stok_fisik" min="0" required>

                <!-- KETERANGAN -->
                <label>Keterangan</label>

                <textarea name="keterangan" placeholder="Contoh: Ada buku rusak / hilang"></textarea>

                <!-- INFO -->
                <div class="info-box">

                    Sistem akan:
                    <br><br>

                    ✅ menghitung selisih stok otomatis
                    <br>

                    ✅ menyimpan riwayat stock opname
                    <br>

                    ✅ memperbarui stok terbaru koleksi

                </div>

                <!-- FOOTER -->
                <div class="footer">

                    <a href="/admin/koleksi" class="btn cancel">

                        Batal

                    </a>

                    <button class="btn save">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</body>

</html>