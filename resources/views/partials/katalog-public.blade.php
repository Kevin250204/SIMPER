<style>
    .katalog-section {
        padding: 80px 0;
    }

    .katalog-section .container {
        max-width: 1200px;
        margin: auto;
    }

    .section-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .section-header h2 {
        font-size: 40px;
        color: #1f2937;
        margin-bottom: 10px;
    }

    .section-header p {
        color: #6b7280;
    }

    .search-form {
        display: grid;
        grid-template-columns: 220px 1fr 180px;
        gap: 15px;
        margin-bottom: 35px;
    }

    .search-form select,
    .search-form input {
        height: 55px;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 0 15px;
    }

    .search-form button {
        border: none;
        background: #0F8248;
        color: white;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .katalog-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
    }

    .katalog-card {
        background: white;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        transition: .3s;
    }

    .katalog-card:hover {
        transform: translateY(-4px);
    }

    .katalog-card img {
        width: 100%;
        height: 260px;
        object-fit: contain;
        background: #f8fafc;
        padding: 10px;
    }

    .katalog-body {
        padding: 12px;
    }

    .katalog-body small {
        color: #777;
    }

    .katalog-body h4 {
        margin-top: 5px;
        font-size: 16px;
    }

    .pagination-wrapper {
        margin-top: 40px;
    }
</style>
<section id="katalog" class="katalog-section">

    <div class="container">

        <div class="section-header">

            <h2>Katalog Koleksi</h2>

            <p>
                Temukan berbagai koleksi buku
                yang tersedia di perpustakaan
            </p>

        </div>

        <form method="GET" action="#katalog" class="search-form">

            <select name="jenis">

                <option value="">
                    Semua Kategori
                </option>

                @foreach($jenisKoleksi as $jenis)

                    <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>

                        {{ $jenis }}

                    </option>

                @endforeach

            </select>

            <input type="text" name="search" placeholder="Cari judul, penulis, penerbit..."
                value="{{ request('search') }}">

            <button type="submit">
                Cari Koleksi
            </button>

        </form>

        <div class="katalog-grid">

            @forelse($koleksis as $koleksi)

                <div class="katalog-card">

                    <img src="{{ asset('uploads/koleksi/' . $koleksi->gambar) }}" alt="{{ $koleksi->judul_koleksi }}">

                    <div class="katalog-body">

                        <small>
                            {{ $koleksi->penulis }}
                        </small>

                        <h4>
                            {{ $koleksi->judul_koleksi }}
                        </h4>

                    </div>

                </div>

            @empty

                <div class="empty">

                    Koleksi tidak ditemukan

                </div>

            @endforelse

        </div>

        <div class="pagination-wrapper">

            {{ $koleksis->links('vendor.pagination.custom') }}

        </div>

    </div>

</section>

<script>
    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const hash =
                window.location.hash;

            if (hash === '#katalog') {

                document
                    .getElementById('katalog')
                    ?.scrollIntoView({
                        behavior: 'smooth'
                    });
            }
        }
    );
</script>