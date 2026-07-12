<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with([
            'anggota',
            'detail.koleksi'
        ]);

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($request->tanggal_awal) {
            $query->whereDate(
                'tanggal_pinjam',
                '>=',
                $request->tanggal_awal
            );
        }

        if ($request->tanggal_akhir) {
            $query->whereDate(
                'tanggal_pinjam',
                '<=',
                $request->tanggal_akhir
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if (
            $request->status &&
            $request->status != 'semua'
        ) {

            $query->where(
                'status_peminjaman',
                $request->status
            );

        }

        /*
        |--------------------------------------------------------------------------
        | PENCARIAN
        |--------------------------------------------------------------------------
        */

        if ($request->keyword) {

            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {

                $q->whereHas(
                    'anggota',
                    function ($anggota) use ($keyword) {

                        $anggota->where(
                            'nama_lengkap',
                            'like',
                            "%{$keyword}%"
                        )->orWhere(
                                'nis',
                                'like',
                                "%{$keyword}%"
                            );

                    }
                )

                    ->orWhereHas(
                        'detail.koleksi',
                        function ($koleksi) use ($keyword) {

                            $koleksi->where(
                                'judul_koleksi',
                                'like',
                                "%{$keyword}%"
                            );

                        }
                    );

            });

        }
        $laporan = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $filteredData = clone $query;

        $totalPeminjaman = (clone $filteredData)
            ->whereIn(
                'status_peminjaman',
                ['dipinjam', 'selesai']
            )
            ->count();

        $sedangAktif = (clone $filteredData)
            ->where(
                'status_peminjaman',
                'dipinjam'
            )
            ->count();

        $selesaiKembali = (clone $filteredData)
            ->where(
                'status_peminjaman',
                'selesai'
            )
            ->count();

        $terlambat = (clone $filteredData)
            ->whereHas(
                'detail',
                function ($q) {

                    $q->where(
                        'status_item',
                        'terlambat'
                    );

                }
            )
            ->count();

        $totalDenda = (clone $filteredData)
            ->sum('total_denda');

        return view(
            'admin.laporan.index',
            compact(
                'totalPeminjaman',
                'sedangAktif',
                'selesaiKembali',
                'terlambat',
                'totalDenda',
                'laporan'
            )
        );
    }

    public function exportPdf(Request $request)
    {
        $query = Peminjaman::with([
            'anggota',
            'detail.koleksi'
        ]);

        if ($request->tanggal_awal) {
            $query->whereDate(
                'tanggal_pinjam',
                '>=',
                $request->tanggal_awal
            );
        }

        if ($request->tanggal_akhir) {
            $query->whereDate(
                'tanggal_pinjam',
                '<=',
                $request->tanggal_akhir
            );
        }

        if (
            $request->status &&
            $request->status != 'semua'
        ) {
            $query->where(
                'status_peminjaman',
                $request->status
            );
        }

        if ($request->keyword) {

            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {

                $q->whereHas(
                    'anggota',
                    function ($anggota) use ($keyword) {

                        $anggota->where(
                            'nama_lengkap',
                            'like',
                            "%{$keyword}%"
                        )->orWhere(
                                'nis',
                                'like',
                                "%{$keyword}%"
                            );

                    }
                )

                    ->orWhereHas(
                        'detail.koleksi',
                        function ($koleksi) use ($keyword) {

                            $koleksi->where(
                                'judul_koleksi',
                                'like',
                                "%{$keyword}%"
                            );

                        }
                    );

            });
        }

        $laporan = $query->latest()->get();

        $totalPeminjaman = (clone $query)
            ->whereIn(
                'status_peminjaman',
                ['dipinjam', 'selesai']
            )
            ->count();

        $sedangAktif = (clone $query)
            ->where('status_peminjaman', 'dipinjam')
            ->count();

        $selesai = (clone $query)
            ->where('status_peminjaman', 'selesai')
            ->count();

        $terlambat = (clone $query)
            ->whereHas('detail', function ($q) {
                $q->where('status_item', 'terlambat');
            })
            ->count();

        $totalDenda = (clone $query)
            ->sum('total_denda');

        $periodeAwal =
            $request->tanggal_awal
            ? date(
                'd-m-Y',
                strtotime(
                    $request->tanggal_awal
                )
            )
            : '-';

        $periodeAkhir =
            $request->tanggal_akhir
            ? date(
                'd-m-Y',
                strtotime(
                    $request->tanggal_akhir
                )
            )
            : '-';

        $pdf = Pdf::loadView(
            'admin.laporan.pdf',
            compact(
                'laporan',
                'totalPeminjaman',
                'sedangAktif',
                'selesai',
                'terlambat',
                'totalDenda',
                'periodeAwal',
                'periodeAkhir'
            )
        );

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download(
            'laporan-peminjaman.pdf'
        );
    }

}