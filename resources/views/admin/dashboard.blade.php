<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    body {
        background: #f4f6f8;
    }

    /* =======================
   LAYOUT
======================= */

    .wrapper {
        display: flex;
        min-height: 100vh;
    }

    /* =======================
   SIDEBAR
======================= */

    /* =======================
   CONTENT
======================= */

    .content {
        flex: 1;
        padding: 25px 30px;
        margin-left: 300px;
    }

    .page-title {
        font-size: 30px;
        color: #166534;
        font-weight: 700;
    }

    .page-subtitle {
        color: #64748b;
        margin-top: 6px;
        margin-bottom: 25px;
    }



    /* =======================
   CARDS
======================= */

    .cards {
        display: grid;
        grid-template-columns:
            repeat(auto-fit,
                minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .card {
        background: white;
        border-radius: 18px;
        padding: 24px;
        box-shadow:
            0 6px 18px rgba(0, 0, 0, .06);
    }

    .card h4 {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 10px;
    }

    .card h2 {
        font-size: 36px;
        color: #166534;
    }

    /* =======================
   CHART GRID
======================= */

    .dashboard-grid {
        display: grid;
        grid-template-columns:
            2fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .chart-card {
        background: white;
        border-radius: 18px;
        padding: 24px;
        box-shadow:
            0 6px 18px rgba(0, 0, 0, .06);
    }

    .chart-card h3 {
        color: #166534;
        margin-bottom: 20px;
    }

    canvas {
        max-height: 320px;
    }

    /* =======================
   TABLE
======================= */

    .table-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow:
            0 6px 18px rgba(0, 0, 0, .06);
    }

    .table-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
    }

    .table-header h3 {
        color: #166534;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #e9f7ef;
        color: #166534;
        text-align: left;
        padding: 14px;
    }

    td {
        padding: 14px;
        border-bottom: 1px solid #eee;
    }

    tbody tr:hover {
        background: #f8fafc;
    }

    /* =======================
   BADGE
======================= */

    .badge {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .proses {
        background: #fef3c7;
        color: #92400e;
    }

    .dipinjam {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .selesai {
        background: #dcfce7;
        color: #166534;
    }

    .terlambat {
        background: #fee2e2;
        color: #991b1b;
    }

    .ditolak {
        background: #fee2e2;
        color: #dc2626;
    }

    .success-alert {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-weight: 600;
        animation: fadeIn .3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* =======================
   MOBILE
======================= */

    @media(max-width:1200px) {

        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <div class="wrapper">

        @include('components.admin-sidebar')

        <!-- CONTENT -->
        <div class="content">

            @include('partials.navbar-admin')

            @if(session('success'))

            <div class="success-alert" id="successAlert">
                ✅ {{ session('success') }}
            </div>

            <script>
            setTimeout(() => {
                let alert = document.getElementById('successAlert');

                if (alert) {
                    alert.style.opacity = '0';

                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }
            }, 3000);
            </script>

            @endif

            <!-- CARD STATISTIK -->

            <div class="cards">

                <div class="card">

                    <h4>Total Koleksi</h4>

                    <h2>
                        {{ $totalKoleksi }}
                    </h2>

                </div>

                <div class="card">

                    <h4>Total Anggota</h4>

                    <h2>
                        {{ $totalAnggota }}
                    </h2>

                </div>

                <div class="card">

                    <h4>Sedang Dipinjam</h4>

                    <h2>
                        {{ $totalDipinjam }}
                    </h2>

                </div>

                <div class="card">

                    <h4>Keterlambatan</h4>

                    <h2>
                        {{ $totalTerlambat }}
                    </h2>

                </div>

            </div>

            <!-- CHART -->

            <div class="dashboard-grid">

                <div class="chart-card">
                    <h3>📈 Peminjaman 7 Hari Terakhir</h3>

                    <canvas id="pinjamChart" height="300"></canvas>

                </div>

                <div class="chart-card">
                    <h3>📦 Struktur Koleksi</h3>

                    <canvas id="kategoriChart" height="300"></canvas>
                </div>

            </div>

            <!-- TABLE -->

            <div class="table-card">

                <div class="table-header">

                    <h3>
                        📦 Peminjaman Terbaru
                    </h3>

                </div>

                <table>

                    <thead>

                        <tr>

                            <th>Anggota</th>

                            <th>Koleksi</th>

                            <th>Tanggal</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($terbaru as $p)

                        <tr>

                            <td>
                                {{ $p->anggota->nama_lengkap }}
                            </td>

                            <td>

                                @foreach($p->detail as $detail)

                                {{ $detail->koleksi->judul_koleksi }}
                                <br>

                                @endforeach

                            </td>

                            <td>
                                {{ $p->tanggal_pinjam }}
                            </td>

                            <td>

                                <span class="badge {{ $p->status_peminjaman }}">

                                    {{ ucfirst($p->status_peminjaman) }}

                                </span>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="4" style="text-align:center">

                                Belum ada data

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    @php

    $hariChart = collect($pinjamMingguan)
    ->pluck('hari')
    ->toArray();

    $totalChart = collect($pinjamMingguan)
    ->pluck('total')
    ->toArray();

    $kategoriLabel = $kategoriChart
    ->pluck('nama_jenis')
    ->toArray();

    $kategoriTotal = $kategoriChart
    ->pluck('total')
    ->toArray();

    @endphp

    <script>
    const pinjamCtx =
        document.getElementById('pinjamChart');

    new Chart(pinjamCtx, {

        type: 'bar',

        data: {

            labels: @json($hariChart),

            datasets: [{

                label: 'Jumlah Peminjaman',

                data: @json($totalChart),

                backgroundColor: '#0b9444',

                borderRadius: 8

            }]
        },

        options: {

            responsive: true,

            scales: {
                y: {
                    beginAtZero: true,

                    suggestedMax: 20,

                    ticks: {
                        stepSize: 5
                    }
                }
            }
        }

    });
    </script>

    <script>
    const kategoriCtx =
        document.getElementById('kategoriChart');

    new Chart(kategoriCtx, {

        type: 'pie',

        data: {

            labels: @json($kategoriLabel),

            datasets: [{

                data: @json($kategoriTotal),

                backgroundColor: [

                    '#22c55e',
                    '#3b82f6',
                    '#f97316',
                    '#ef4444',
                    '#8b5cf6',
                    '#06b6d4',
                    '#eab308'

                ],

                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 10

            }]
        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    position: 'bottom'

                }

            }

        }

    });
    </script>
</body>

</html>