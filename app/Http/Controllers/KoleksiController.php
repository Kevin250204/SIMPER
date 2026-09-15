<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Koleksi;
use App\Models\StockOpname;
use App\Models\DetailPeminjaman;
use App\Models\JenisKoleksi;
use App\Models\KategoriKoleksi;

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
        $idJenis = $request->id_jenis;
        $idKategori = $request->id_kategori;

        $koleksis = Koleksi::with('kategori.jenis')

            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_koleksi', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%")
                        ->orWhere('judul_koleksi', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('penerbit', 'like', "%{$search}%");
                });
            })

            ->when($idJenis, function ($query) use ($idJenis) {
                $query->whereHas('kategori', function ($q) use ($idJenis) {
                    $q->where('id_jenis', $idJenis);
                });
            })

            ->when($idKategori, function ($query) use ($idKategori) {
                $query->where('id_kategori', $idKategori);
            })

            ->orderBy('id_koleksi', 'desc')
            ->paginate(10);

        $jenis = JenisKoleksi::orderBy('nama_jenis')->get();

        $kategori = KategoriKoleksi::orderBy('nama_kategori')->get();

        return view(
            'admin.koleksi.index',
            compact(
                'koleksis',
                'jenis',
                'kategori'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH KOLEKSI
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $jenis = JenisKoleksi::orderBy('nama_jenis')->get();

        $kategori = KategoriKoleksi::orderBy('nama_kategori')->get();

        return view(
            'admin.koleksi.create',
            compact('jenis', 'kategori')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN KOLEKSI
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'kode_koleksi' => 'required|unique:koleksis,kode_koleksi|max:20',
            'isbn' => 'nullable|unique:koleksis,isbn',
            'judul_koleksi' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4',
            'stok' => 'required|integer|min:0',
            'denda_harian' => 'required|integer|min:0',
            'id_kategori' => 'required|exists:kategori_koleksi,id_kategori',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'kode_koleksi.required' => 'Kode koleksi wajib diisi.',

            'kode_koleksi.unique' => 'Kode koleksi sudah digunakan.',

            'kode_koleksi.max' => 'Kode koleksi maksimal 20 karakter.',
            'isbn.unique' => 'ISBN sudah digunakan.',

            'judul_koleksi.required' => 'Judul koleksi wajib diisi.',
            'penulis.required' => 'Penulis wajib diisi.',
            'penerbit.required' => 'Penerbit wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.digits' => 'Tahun terbit harus terdiri dari 4 digit.',

            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',

            'denda_harian.required' => 'Denda harian wajib diisi.',
            'denda_harian.integer' => 'Denda harian harus berupa angka.',

            'id_kategori.required' => 'Kategori koleksi wajib dipilih.',
            'id_kategori.exists' => 'Kategori koleksi tidak ditemukan.',

            'deskripsi.required' => 'Deskripsi koleksi wajib diisi.',

            'gambar.required' => 'Cover koleksi wajib diunggah.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Cover harus berformat JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
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

            'kode_koleksi' => $request->kode_koleksi,

            'isbn' => $request->isbn,

            'judul_koleksi' => $request->judul_koleksi,

            'penulis' => $request->penulis,

            'penerbit' => $request->penerbit,

            'tahun_terbit' => $request->tahun_terbit,

            'stok' => $request->stok,

            'denda_harian' => $request->denda_harian,

            'id_kategori' => $request->id_kategori,

            'deskripsi' => $request->deskripsi,

            'gambar' => $namaFile

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
        $koleksi = Koleksi::findOrFail($id_koleksi);

        $jenis = JenisKoleksi::orderBy('nama_jenis')->get();

        $kategori = KategoriKoleksi::orderBy('nama_kategori')->get();

        $idJenisTerpilih = KategoriKoleksi::where(
            'id_kategori',
            $koleksi->id_kategori
        )->value('id_jenis');

        return view(
            'admin.koleksi.edit',
            compact(
                'koleksi',
                'jenis',
                'kategori',
                'idJenisTerpilih'
            )
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
            'kode_koleksi' =>
                'required|unique:koleksis,kode_koleksi,' .
                $id_koleksi .
                ',id_koleksi',
            'isbn' => 'nullable|unique:koleksis,isbn,' . $id_koleksi . ',id_koleksi',
            'judul_koleksi' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4',
            'stok' => 'required|integer|min:0',
            'denda_harian' => 'required|integer|min:0',
            'id_kategori' => 'required|exists:kategori_koleksi,id_kategori',
            'deskripsi' => 'required|string',

            // gambar tidak wajib saat edit
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ], [
            'kode_koleksi.required' => 'Kode koleksi wajib diisi.',

            'kode_koleksi.unique' => 'Kode koleksi sudah digunakan.',

            'kode_koleksi.max' => 'Kode koleksi maksimal 20 karakter.',

            'isbn.unique' => 'ISBN sudah digunakan.',

            'judul_koleksi.required' => 'Judul koleksi wajib diisi.',

            'penulis.required' => 'Penulis wajib diisi.',

            'penerbit.required' => 'Penerbit wajib diisi.',

            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.digits' => 'Tahun terbit harus terdiri dari 4 digit.',

            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok minimal 0.',

            'denda_harian.required' => 'Denda harian wajib diisi.',
            'denda_harian.integer' => 'Denda harian harus berupa angka.',
            'denda_harian.min' => 'Denda harian minimal 0.',

            'id_kategori.required' => 'Kategori koleksi wajib dipilih.',
            'id_kategori.exists' => 'Kategori koleksi tidak ditemukan.',

            'deskripsi.required' => 'Deskripsi koleksi wajib diisi.',

            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Cover harus berformat JPG, JPEG, atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',

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

            'kode_koleksi' =>
                $request->kode_koleksi,

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

            'id_kategori' => $request->id_kategori,

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
        $koleksi = Koleksi::findOrFail($id_koleksi);

        // Cek apakah koleksi masih dipinjam
        $masihDipinjam = DetailPeminjaman::join(
            'peminjaman',
            'detail_peminjaman.id_peminjaman',
            '=',
            'peminjaman.id_peminjaman'
        )
            ->where('detail_peminjaman.id_koleksi', $id_koleksi)
            ->whereIn(
                'peminjaman.status_peminjaman',
                [
                    'proses',
                    'dipinjam'
                ]
            )
            ->exists();

        if ($masihDipinjam) {

            return redirect('/admin/koleksi')
                ->with(
                    'error',
                    'Koleksi tidak dapat dihapus karena masih memiliki transaksi peminjaman yang belum selesai.'
                );

        }

        $koleksi->delete();

        return redirect('/admin/koleksi')
            ->with(
                'success',
                'Koleksi berhasil dihapus dari daftar koleksi.'
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

            'id_koleksi' => 'required',

            'stok_fisik' => 'required|integer|min:0',

            'keterangan' => 'nullable|string',

        ], [

            'id_koleksi.required' => 'Silakan pilih koleksi.',

            'stok_fisik.required' => 'Stok fisik wajib diisi.',

            'stok_fisik.integer' => 'Stok fisik harus berupa angka.',

            'stok_fisik.min' => 'Nilai stok harus lebih besar atau sama dengan 0.',

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

    public function kategoriByJenis($id)
    {
        return KategoriKoleksi::where(
            'id_jenis',
            $id
        )
            ->orderBy('nama_kategori')
            ->get();
    }
}