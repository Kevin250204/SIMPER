<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Koleksi;
use App\Models\StockOpname;

class KoleksiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST DATA KOLEKSI
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = $request->search;

        $koleksis = Koleksi::when(
            $search,
            function ($query, $search) {

                $query->where(
                    'isbn',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'judul_koleksi',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'penulis',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'penerbit',
                        'like',
                        "%{$search}%"
                    );
            }
        )
            ->orderBy('id_koleksi', 'desc')
            ->paginate(10);

        return view(
            'admin.koleksi.index',
            compact('koleksis')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH KOLEKSI
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.koleksi.create');
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN KOLEKSI
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'isbn' =>
                'required|unique:koleksis,isbn',

            'judul_koleksi' =>
                'required|string|max:255',

            'penulis' =>
                'required|string|max:255',

            'penerbit' =>
                'required|string|max:255',

            'tahun_terbit' =>
                'required|digits:4',

            'stok' =>
                'required|integer|min:0',

            'denda_harian' =>
                'required|integer|min:0',

            'jenis_koleksi' =>
                'required|string|max:100',

            'deskripsi' =>
                'nullable|string',

            'gambar' =>
                'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $namaFile = null;

        /*
        |--------------------------------------------------------------------------
        | UPLOAD GAMBAR
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('gambar')) {

            $namaFile =
                time() . '_' .
                $request->file('gambar')
                    ->getClientOriginalName();

            $request->file('gambar')->move(
                public_path('uploads/koleksi'),
                $namaFile
            );
        }

        Koleksi::create([

            'isbn' =>
                $request->isbn,

            'judul_koleksi' =>
                $request->judul_koleksi,

            'penulis' =>
                $request->penulis,

            'penerbit' =>
                $request->penerbit,

            'tahun_terbit' =>
                $request->tahun_terbit,

            'stok' =>
                $request->stok,

            'denda_harian' =>
                $request->denda_harian,

            'jenis_koleksi' =>
                $request->jenis_koleksi,

            'deskripsi' =>
                $request->deskripsi,

            'gambar' =>
                $namaFile,
        ]);

        return redirect('/admin/koleksi')
            ->with(
                'success',
                'Koleksi berhasil ditambahkan'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id_koleksi)
    {
        $koleksi = Koleksi::findOrFail(
            $id_koleksi
        );

        return view(
            'admin.koleksi.edit',
            compact('koleksi')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE KOLEKSI
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id_koleksi
    ) {

        $request->validate([

            'isbn' =>
                'required|unique:koleksis,isbn,' .
                $id_koleksi .
                ',id_koleksi',

            'judul_koleksi' =>
                'required|string|max:255',

            'penulis' =>
                'required|string|max:255',

            'penerbit' =>
                'required|string|max:255',

            'tahun_terbit' =>
                'required|digits:4',

            'stok' =>
                'required|integer|min:0',

            'denda_harian' =>
                'required|integer|min:0',

            'jenis_koleksi' =>
                'required|string|max:100',

            'deskripsi' =>
                'nullable|string',

            'gambar' =>
                'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $koleksi = Koleksi::findOrFail(
            $id_koleksi
        );

        $namaFile = $koleksi->gambar;

        /*
        |--------------------------------------------------------------------------
        | GANTI GAMBAR
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('gambar')) {

            if (
                $koleksi->gambar &&
                file_exists(
                    public_path(
                        'uploads/koleksi/' .
                        $koleksi->gambar
                    )
                )
            ) {

                unlink(
                    public_path(
                        'uploads/koleksi/' .
                        $koleksi->gambar
                    )
                );
            }

            $namaFile =
                time() . '_' .
                $request->file('gambar')
                    ->getClientOriginalName();

            $request->file('gambar')->move(
                public_path('uploads/koleksi'),
                $namaFile
            );
        }

        $koleksi->update([

            'isbn' =>
                $request->isbn,

            'judul_koleksi' =>
                $request->judul_koleksi,

            'penulis' =>
                $request->penulis,

            'penerbit' =>
                $request->penerbit,

            'tahun_terbit' =>
                $request->tahun_terbit,

            'stok' =>
                $request->stok,

            'denda_harian' =>
                $request->denda_harian,

            'jenis_koleksi' =>
                $request->jenis_koleksi,

            'deskripsi' =>
                $request->deskripsi,

            'gambar' =>
                $namaFile,
        ]);

        return redirect('/admin/koleksi')
            ->with(
                'success',
                'Data koleksi berhasil diperbarui'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS KOLEKSI
    |--------------------------------------------------------------------------
    */

    public function destroy($id_koleksi)
    {
        $koleksi = Koleksi::findOrFail(
            $id_koleksi
        );

        DB::transaction(function () use ($koleksi) {

            if (
                $koleksi->gambar &&
                file_exists(
                    public_path(
                        'uploads/koleksi/' .
                        $koleksi->gambar
                    )
                )
            ) {

                unlink(
                    public_path(
                        'uploads/koleksi/' .
                        $koleksi->gambar
                    )
                );
            }

            $koleksi->delete();
        });

        return redirect('/admin/koleksi')
            ->with(
                'success',
                'Data koleksi berhasil dihapus'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM STOCK OPNAME
    |--------------------------------------------------------------------------
    */

    public function stockOpname()
    {
        $koleksis = Koleksi::all();

        return view(
            'admin.koleksi.stock_opname',
            compact('koleksis')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN STOCK OPNAME
    |--------------------------------------------------------------------------
    */

    public function storeStockOpname(Request $request)
    {
        $request->validate([

            'id_koleksi' =>
                'required',

            'stok_fisik' =>
                'required|integer|min:0',

            'keterangan' =>
                'nullable|string',
        ]);

        $koleksi = Koleksi::findOrFail(
            $request->id_koleksi
        );

        DB::transaction(function () use ($request, $koleksi) {

            $selisih =
                $request->stok_fisik -
                $koleksi->stok;

            StockOpname::create([

                'id_koleksi' =>
                    $koleksi->id_koleksi,

                'tanggal_opname' =>
                    now(),

                'stok_sistem' =>
                    $koleksi->stok,

                'stok_fisik' =>
                    $request->stok_fisik,

                'selisih' =>
                    $selisih,

                'jumlah_terbaru' =>
                    $request->stok_fisik,

                'keterangan' =>
                    $request->keterangan,
            ]);

            $koleksi->update([

                'stok' =>
                    $request->stok_fisik
            ]);
        });

        return redirect('/admin/koleksi')
            ->with(
                'success',
                'Stock opname berhasil disimpan'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL KOLEKSI
    |--------------------------------------------------------------------------
    */

    public function detail($id_koleksi)
    {
        $koleksi = Koleksi::findOrFail(
            $id_koleksi
        );

        $riwayat = StockOpname::where(
            'id_koleksi',
            $id_koleksi
        )
            ->orderBy(
                'tanggal_opname',
                'desc'
            )
            ->get();

        return view(
            'admin.koleksi.detail',
            compact(
                'koleksi',
                'riwayat'
            )
        );
    }
}