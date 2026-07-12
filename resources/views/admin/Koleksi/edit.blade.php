<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Koleksi</title>

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

        textarea {
            resize: none;
            height: 80px;
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

        .preview-image {
            width: 140px;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-top: 8px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="overlay">

        <div class="modal-card">

            <div class="modal-header">
                <h3>✏️ Edit Koleksi</h3>

                <a href="/admin/koleksi" class="close-btn">
                    &times;
                </a>
            </div>

            @if($errors->any())

                <div class="alert-error">

                    <ul style="margin:0;padding-left:18px;">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="/admin/koleksi/{{ $koleksi->id_koleksi }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <label>ISBN</label>
                <input type="text" name="isbn" value="{{ old('isbn', $koleksi->isbn) }}" required>

                <label>Judul Koleksi</label>
                <input type="text" name="judul_koleksi" value="{{ old('judul_koleksi', $koleksi->judul_koleksi) }}"
                    required>

                <label>Penulis</label>
                <input type="text" name="penulis" value="{{ old('penulis', $koleksi->penulis) }}" required>

                <label>Penerbit</label>
                <input type="text" name="penerbit" value="{{ old('penerbit', $koleksi->penerbit) }}" required>

                <label>Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $koleksi->tahun_terbit) }}"
                    required>

                <label>Stok</label>
                <input type="number" name="stok" min="0" value="{{ old('stok', $koleksi->stok) }}" required>

                <label>Denda Harian</label>
                <input type="number" name="denda_harian" min="0"
                    value="{{ old('denda_harian', $koleksi->denda_harian) }}" required>

                <label>Jenis Koleksi</label>

                <select name="jenis_koleksi" required>

                    <option value="">-- Pilih Jenis --</option>

                    <option value="Buku" {{ $koleksi->jenis_koleksi == 'Buku' ? 'selected' : '' }}>
                        Buku
                    </option>

                    <option value="Majalah" {{ $koleksi->jenis_koleksi == 'Majalah' ? 'selected' : '' }}>
                        Majalah
                    </option>

                    <option value="Jurnal" {{ $koleksi->jenis_koleksi == 'Jurnal' ? 'selected' : '' }}>
                        Jurnal
                    </option>

                    <option value="Novel" {{ $koleksi->jenis_koleksi == 'Novel' ? 'selected' : '' }}>
                        Novel
                    </option>

                </select>

                <label>Deskripsi Koleksi</label>

                <textarea name="deskripsi" rows="5">{{ old('deskripsi', $koleksi->deskripsi) }}</textarea>

                <label>Cover Saat Ini</label>

                @if($koleksi->gambar)

                    <img src="{{ asset('uploads/koleksi/' . $koleksi->gambar) }}" class="preview-image">

                @else

                    <p>Tidak ada gambar</p>

                @endif

                <label>Ganti Gambar</label>

                <input type="file" name="gambar" accept="image/*">

                <small>
                    Format: JPG, JPEG, PNG (Maks 2MB)
                </small>

                <div class="modal-footer">

                    <a href="/admin/koleksi" class="btn btn-cancel">

                        Batal

                    </a>

                    <button type="submit" class="btn btn-save">

                        Update

                    </button>

                </div>

            </form>

        </div>

    </div>

</body>

</html>