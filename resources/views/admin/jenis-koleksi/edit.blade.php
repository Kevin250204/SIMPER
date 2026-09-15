<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Jenis Koleksi</title>

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

    .text-error {
        display: block;
        margin-top: 5px;
        color: #dc2626;
        font-size: 13px;
        font-weight: 500;
    }

    input.error,
    select.error,
    textarea.error {
        border: 1px solid #dc2626;
    }
    </style>
</head>

<body>

    <div class="overlay">

        <div class="modal-card">

            <div class="modal-header">
                <h3>✏️ Edit Jenis Koleksi</h3>

                <a href="{{ route('jenis-koleksi.index') }}" class="close-btn">
                    &times;
                </a>
            </div>

            <form action="{{ route('jenis-koleksi.update', $jenis->id_jenis) }}" method="POST"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <label>Nama Jenis Koleksi</label>

                <input type="text" name="nama_jenis" value="{{ old('nama_jenis', $jenis->nama_jenis) }}">

                @error('nama_jenis')

                <small class="text-error">

                    {{ $message }}

                </small>

                @enderror

                <div class="modal-footer">

                    <a href="{{ route('jenis-koleksi.index') }}" class="btn btn-cancel">

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