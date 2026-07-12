<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Koleksi</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #0b9444, #0f7f3b);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-card {
            background: #fff;
            width: 550px;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, .25);
            max-height: 95vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
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

        label {
            display: block;
            margin-top: 14px;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #16a34a;
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
        }

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

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        small {
            color: #666;
            display: block;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="overlay">

        <div class="modal-card">

            <!-- HEADER -->
            <div class="modal-header">

                <h3>📚 Tambah Koleksi</h3>

                <a href="/admin/koleksi" class="close-btn">
                    &times;
                </a>

            </div>

            <!-- ERROR -->
            @if($errors->any())

                <div class="alert-error">

                    <ul style="margin:0;padding-left:18px;">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <!-- FORM -->
            <form action="/admin/koleksi" method="POST" enctype="multipart/form-data">

                @csrf

                <!-- ISBN -->
                <label>ISBN</label>

                <input type="text" name="isbn" value="{{ old('isbn') }}" required>

                <!-- JUDUL -->
                <label>Judul Koleksi</label>

                <input type="text" name="judul_koleksi" value="{{ old('judul_koleksi') }}" required>

                <!-- PENULIS -->
                <label>Penulis</label>

                <input type="text" name="penulis" value="{{ old('penulis') }}" required>

                <!-- PENERBIT -->
                <label>Penerbit</label>

                <input type="text" name="penerbit" value="{{ old('penerbit') }}" required>

                <!-- TAHUN -->
                <label>Tahun Terbit</label>

                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required>

                <!-- STOK -->
                <label>Stok</label>

                <input type="number" name="stok" min="0" value="{{ old('stok') }}" required>

                <!-- DENDA -->
                <label>Denda Harian</label>

                <input type="number" name="denda_harian" min="0" value="{{ old('denda_harian') }}"
                    placeholder="Contoh: 1000" required>

                <!-- JENIS -->
                <label>Jenis Koleksi</label>

                <select name="jenis_koleksi" required>

                    <option value="">-- Pilih Jenis --</option>

                    <option value="Buku" {{ old('jenis_koleksi') == 'Buku' ? 'selected' : '' }}>
                        Buku
                    </option>

                    <option value="Majalah" {{ old('jenis_koleksi') == 'Majalah' ? 'selected' : '' }}>
                        Majalah
                    </option>

                    <option value="Jurnal" {{ old('jenis_koleksi') == 'Jurnal' ? 'selected' : '' }}>
                        Jurnal
                    </option>

                    <option value="Novel" {{ old('jenis_koleksi') == 'Novel' ? 'selected' : '' }}>
                        Novel
                    </option>

                </select>

                <label>Deskripsi Koleksi</label>

                <textarea name="deskripsi" rows="5"
                    placeholder="Masukkan deskripsi koleksi...">{{ old('deskripsi') }}</textarea>

                <!-- GAMBAR -->
                <label>Cover Koleksi</label>

                <input type="file" name="gambar" accept=".jpg,.jpeg,.png,image/*">

                <small>
                    Format yang diperbolehkan: JPG, JPEG, PNG (maksimal 2 MB)
                </small>

                <!-- FOOTER -->
                <div class="modal-footer">

                    <a href="/admin/koleksi" class="btn btn-cancel">

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