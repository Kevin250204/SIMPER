<?php

namespace App\Http\Controllers;

use App\Models\Koleksi;
use App\Models\AnggotaPerpustakaan;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL DATA
        |--------------------------------------------------------------------------
        */

        $totalKoleksi = Koleksi::count();

        $totalAnggota = AnggotaPerpustakaan::count();

        $totalDipinjam = Peminjaman::where(
            'status_peminjaman',
            'dipinjam'
        )->count();

        $totalTerlambat = Peminjaman::where(
            'status_peminjaman',
            'dipinjam'
        )
            ->whereHas('detail', function ($q) {
                $q->where('status_item', 'terlambat');
            })
            ->count();

        /*
        |--------------------------------------------------------------------------
        | PEMINJAMAN TERBARU
        |--------------------------------------------------------------------------
        */

        $terbaru = Peminjaman::with([
            'anggota',
            'detail.koleksi'
        ])
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA CHART PEMINJAMAN 7 HARI
        |--------------------------------------------------------------------------
        */

        $pinjamMingguan = [];

        for ($i = 6; $i >= 0; $i--) {

            $tanggal = Carbon::now()->subDays($i);

            $total = Peminjaman::whereDate(
                'created_at',
                $tanggal
            )->count();

            $namaHari = [
                'Sun' => 'Minggu',
                'Mon' => 'Senin',
                'Tue' => 'Selasa',
                'Wed' => 'Rabu',
                'Thu' => 'Kamis',
                'Fri' => 'Jumat',
                'Sat' => 'Sabtu'
            ];

            $pinjamMingguan[] = [
                'hari' => $namaHari[$tanggal->format('D')],
                'total' => $total
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | DATA PIE CHART KATEGORI KOLEKSI
        |--------------------------------------------------------------------------
        */

        $kategoriChart = DB::table('koleksis')
            ->join('kategori_koleksi', 'koleksis.id_kategori', '=', 'kategori_koleksi.id_kategori')
            ->join('jenis_koleksi', 'kategori_koleksi.id_jenis', '=', 'jenis_koleksi.id_jenis')
            ->select(
                'jenis_koleksi.nama_jenis',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('jenis_koleksi.nama_jenis')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.dashboard',
            compact(
                'totalKoleksi',
                'totalAnggota',
                'totalDipinjam',
                'totalTerlambat',
                'terbaru',
                'pinjamMingguan',
                'kategoriChart'
            )
        );
    }
}