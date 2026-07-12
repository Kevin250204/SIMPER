<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koleksi;
use App\Models\AnggotaPerpustakaan;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $jenis = $request->jenis;

        $query = Koleksi::query();

        /*
        |--------------------------------------------------------------------------
        | FILTER JENIS KOLEKSI
        |--------------------------------------------------------------------------
        */

        if (!empty($jenis) && $jenis != 'Semua') {
            $query->where('jenis_koleksi', $jenis);
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if (!empty($keyword)) {

            $query->where(function ($q) use ($keyword) {

                $q->where(
                    'judul_koleksi',
                    'like',
                    '%' . $keyword . '%'
                )

                    ->orWhere(
                        'penulis',
                        'like',
                        '%' . $keyword . '%'
                    )

                    ->orWhere(
                        'penerbit',
                        'like',
                        '%' . $keyword . '%'
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $koleksis = $query
            ->latest()
            ->paginate(10);

        $jenisKoleksi = Koleksi::select('jenis_koleksi')
            ->distinct()
            ->pluck('jenis_koleksi');

        $totalKoleksi = Koleksi::count();

        $totalAnggota = AnggotaPerpustakaan::count();

        return view(
            'landing',
            compact(
                'koleksis',
                'jenisKoleksi',
                'totalKoleksi',
                'totalAnggota'
            )
        );
    }

    public function menuPeminjaman()
    {
        if (
            !session()->has('id_user')
            ||
            session('role') != 'anggota'
        ) {

            return redirect('/login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu'
                );
        }

        return redirect('/anggota/peminjaman');
    }

    public function detailKoleksi($id)
    {
        $koleksi = Koleksi::findOrFail($id);

        return view(
            'detail-koleksi',
            compact('koleksi')
        );
    }
}