<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koleksi;
use App\Models\AnggotaPerpustakaan;
use App\Models\JenisKoleksi;
use Illuminate\Support\Facades\DB;
use App\Models\DetailPeminjaman;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $jenis = $request->jenis;

        $query = Koleksi::with('kategori.jenis');

        /*
        |--------------------------------------------------------------------------
        | FILTER JENIS KOLEKSI
        |--------------------------------------------------------------------------
        */

        if (!empty($jenis) && $jenis != 'Semua') {

            $query->whereHas('kategori.jenis', function ($q) use ($jenis) {
                $q->where('nama_jenis', $jenis);
            });

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

        $jenisKoleksi = JenisKoleksi::orderBy('nama_jenis')
            ->pluck('nama_jenis');

        $totalKoleksi = Koleksi::count();

        $totalAnggota = AnggotaPerpustakaan::count();

        $bukuPopuler = Koleksi::with('kategori.jenis')
            ->withCount([
                'detailPeminjaman as total_pinjam'
            ])
            ->orderByDesc('total_pinjam')
            ->take(4)
            ->get();

        $bukuTerbaru = Koleksi::with('kategori.jenis')
            ->orderByDesc('created_at')
            ->take(4)
            ->get();

        return view(
            'landing',
            compact(
                'koleksis',
                'jenisKoleksi',
                'totalKoleksi',
                'totalAnggota',
                'bukuPopuler',
                'bukuTerbaru'
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