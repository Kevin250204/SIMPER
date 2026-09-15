<!DOCTYPE html>
<html lang="id">

<head>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

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

        .text-error {
            display: block;
            margin-top: 5px;
            color: #dc2626;
            font-size: 13px;
        }

        .error {
            border: 1px solid #dc2626 !important;
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

            <!-- FORM -->
            <form method="POST" action="/admin/stock-opname">

                @csrf

                <!-- KOLEKSI -->

                <label>Pilih Koleksi</label>

                <select id="koleksi" name="id_koleksi" class="@error('id_koleksi') error @enderror">

                    <option value="">
                        Cari berdasarkan Judul atau ISBN...
                    </option>

                    @foreach($koleksis as $koleksi)

                        <option value="{{ $koleksi->id_koleksi }}" {{ old('id_koleksi') == $koleksi->id_koleksi ? 'selected' : '' }}>

                            {{ $koleksi->judul_koleksi }}
                            | ISBN : {{ $koleksi->isbn }}
                            | Stok : {{ $koleksi->stok }}

                        </option>

                    @endforeach

                </select>

                @error('id_koleksi')
                    <small class="text-error">
                        {{ $message }}
                    </small>
                @enderror

                <!-- STOK -->
                <label>Stok Fisik</label>

                <input type="number" name="stok_fisik">
                @error('stok_fisik')
                    <small class="text-error">{{ $message }}</small>
                @enderror

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

    <script>
        new TomSelect("#koleksi", {

            create: false,

            maxItems: 1,

            placeholder: "Cari berdasarkan Judul atau ISBN...",

            searchField: [
                "text"
            ],

            allowEmptyOption: true

        });
    </script>

</body>

</html>