<?php

namespace App\Http\Controllers;

use App\Models\Koleksi;
use App\Models\AnggotaPerpustakaan;
use App\Models\Peminjaman;

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
            'terlambat'
        )->count();

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

        $kategoriChart = Koleksi::select(
            'jenis_koleksi',
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('jenis_koleksi')
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