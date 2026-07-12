<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $koleksi->judul_koleksi }}</title>

    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: #f5f7fa;
    }

    .container {
        max-width: 1300px;
        margin: auto;
        padding: 40px;
    }

    .btn-kembali {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        background: white;
        color: #374151;
        padding: 12px 24px;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
        margin-bottom: 35px;
        font-weight: 600;
    }

    .detail-wrapper {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 50px;
    }

    .cover-side {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .cover-card {
        background: white;
        border-radius: 24px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
    }

    .cover-card img {
        width: 100%;
        height: 450px;
        object-fit: contain;
    }

    .status-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
    }

    .status-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .status-row:last-child {
        border: none;
    }

    .status-label {
        color: #6b7280;
        font-size: 14px;
        font-weight: 600;
    }

    .status-value {
        font-weight: 700;
    }

    .available {
        color: #16a34a;
    }

    .warning {
        color: #f59e0b;
    }

    .danger {
        color: #dc2626;
    }

    .content-side h1 {
        font-size: 54px;
        margin-bottom: 10px;
        color: #111827;
    }

    .author {
        font-size: 28px;
        color: #374151;
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 28px;
        margin-bottom: 20px;
        color: #111827;
    }

    .description {
        font-size: 18px;
        line-height: 1.9;
        color: #4b5563;
        text-align: justify;
        margin-bottom: 40px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .info-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, .05);
    }

    .info-label {
        font-size: 13px;
        text-transform: uppercase;
        color: #9ca3af;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .info-value {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
    }

    .denda-card {
        border: 1px solid #fde68a;
        background: #fffbeb;
    }

    @media(max-width:1000px) {

        .detail-wrapper {
            grid-template-columns: 1fr;
        }

        .info-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .content-side h1 {
            font-size: 38px;
        }

    }
    </style>

</head>

<body>

    @include('components.navbar')

    <div class="container">

        <a href="{{ url()->previous() }}" class="btn-kembali">
            ← Kembali
        </a>

        <div class="detail-wrapper">

            {{-- COVER --}}
            <div class="cover-side">

                <div class="cover-card">

                    @if($koleksi->gambar)

                    <img src="{{ asset('uploads/koleksi/' . $koleksi->gambar) }}">

                    @else

                    <img src="{{ asset('images/no-cover.png') }}">

                    @endif

                </div>

                <div class="status-card">

                    <div class="status-row">

                        <span class="status-label">
                            STATUS
                        </span>

                        <span class="status-value
                        @if($koleksi->stok > 5)
                            available
                        @elseif($koleksi->stok > 0)
                            warning
                        @else
                            danger
                        @endif">

                            @if($koleksi->stok > 5)

                            Tersedia

                            @elseif($koleksi->stok > 0)

                            Hampir Habis

                            @else

                            Kosong

                            @endif

                        </span>

                    </div>

                    <div class="status-row">

                        <span class="status-label">
                            STOK FISIK
                        </span>

                        <span class="status-value">
                            {{ $koleksi->stok }} Unit
                        </span>

                    </div>

                </div>

            </div>

            {{-- KONTEN --}}
            <div class="content-side">

                <h1>
                    {{ $koleksi->judul_koleksi }}
                </h1>

                <div class="author">
                    Karya {{ $koleksi->penulis }}
                </div>

                <div class="section-title">
                    Deskripsi Koleksi
                </div>

                <div class="description">

                    {{ $koleksi->deskripsi ?? 'Belum ada deskripsi koleksi.' }}

                </div>

                <div class="info-grid">

                    <div class="info-card">

                        <div class="info-label">
                            Tahun Terbit
                        </div>

                        <div class="info-value">
                            {{ $koleksi->tahun_terbit }}
                        </div>

                    </div>

                    <div class="info-card">

                        <div class="info-label">
                            ISBN
                        </div>

                        <div class="info-value">
                            {{ $koleksi->isbn }}
                        </div>

                    </div>

                    <div class="info-card">

                        <div class="info-label">
                            Penerbit
                        </div>

                        <div class="info-value">
                            {{ $koleksi->penerbit }}
                        </div>

                    </div>

                    <div class="info-card denda-card">

                        <div class="info-label">
                            Denda Harian
                        </div>

                        <div class="info-value">
                            Rp {{ number_format($koleksi->denda_harian) }}/Hari
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>