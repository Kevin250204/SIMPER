<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\AnggotaPerpustakaan;
use App\Models\Koleksi;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanAdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    public function index()
    {

        $this->updateStatusExpired();
        $this->updateStatusTerlambat();

        $search = request('search');
        $status = request('status');

        $peminjamans = Peminjaman::with([
            'anggota',
            'detail.koleksi'
        ])

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->whereHas('anggota', function ($anggota) use ($search) {

                        $anggota->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nis', 'like', "%{$search}%");

                    })

                        ->orWhereHas('detail.koleksi', function ($koleksi) use ($search) {

                            $koleksi->where('judul_koleksi', 'like', "%{$search}%");

                        })

                        ->orWhere('status_peminjaman', 'like', "%{$search}%");

                });

            })

            ->when($status, function ($query) use ($status) {

                if ($status == 'terlambat') {

                    $query->where('status_peminjaman', 'dipinjam')
                        ->whereHas('detail', function ($q) {
                            $q->where('status_item', 'terlambat');
                        });

                } elseif ($status == 'rusak') {

                    $query->whereHas('detail', function ($q) {
                        $q->where('status_item', 'rusak');
                    });

                } elseif ($status == 'hilang') {

                    $query->whereHas('detail', function ($q) {
                        $q->where('status_item', 'hilang');
                    });

                } else {

                    $query->where('status_peminjaman', $status);

                }

            })

            ->orderBy('id_peminjaman', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.Peminjaman.index',
            compact('peminjamans')
        );
    }

    private function updateStatusExpired()
    {
        $expired = Peminjaman::with('detail')
            ->where('status_peminjaman', 'proses')
            ->where('created_at', '<=', now()->subDays(2))
            ->get();

        foreach ($expired as $peminjaman) {

            foreach ($peminjaman->detail as $detail) {

                $detail->update([
                    'status_item' => 'ditolak'
                ]);

            }

            $peminjaman->update([
                'status_peminjaman' => 'ditolak'
            ]);
        }
    }

    private function updateStatusTerlambat()
    {
        $peminjamans = Peminjaman::with('detail.koleksi')
            ->where('status_peminjaman', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', today())
            ->get();

        foreach ($peminjamans as $peminjaman) {

            $tanggalKembali = \Carbon\Carbon::parse(
                $peminjaman->tanggal_kembali
            );

            $hariTerlambat = abs(
                $tanggalKembali->diffInDays(
                    today(),
                    false
                )
            );

            foreach ($peminjaman->detail as $detail) {

                if (
                    $detail->status_item == 'dipinjam' ||
                    $detail->status_item == 'terlambat'
                ) {

                    $dendaPerHari =
                        $detail->koleksi->denda_harian;

                    $detail->update([
                        'status_item' => 'terlambat',
                        'jumlah_denda' => $hariTerlambat * $dendaPerHari
                    ]);
                }
            }

            $this->updateTotalDenda(
                $peminjaman->id_peminjaman
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    public function detail($id)
    {
        $this->updateStatusExpired();
        $this->updateStatusTerlambat();

        $peminjaman = Peminjaman::with([
            'anggota',
            'detail.koleksi'
        ])->findOrFail($id);

        return view(
            'admin.Peminjaman.detail',
            compact('peminjaman')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    public function approve($id)
    {
        $peminjaman = Peminjaman::with(
            'detail.koleksi'
        )->findOrFail($id);

        /*
        |---------------------------------------------------
        | VALIDASI STATUS
        |---------------------------------------------------
        */
        if (
            !in_array(
                $peminjaman->status_peminjaman,
                ['proses', 'menunggu']
            )
        ) {
            return back()->with(
                'error',
                'Peminjaman sudah diproses'
            );
        }

        DB::transaction(function () use ($peminjaman) {

            /*
            |---------------------------------------------------
            | KURANGI STOK KOLEKSI
            |---------------------------------------------------
            */
            foreach ($peminjaman->detail as $detail) {

                $koleksi = $detail->koleksi;

                /*
                |---------------------------------------------------
                | CEK STOK
                |---------------------------------------------------
                */
                if (
                    $koleksi->stok <
                    $detail->jumlah
                ) {
                    abort(
                        400,
                        'Stok koleksi tidak mencukupi'
                    );
                }

                /*
                |---------------------------------------------------
                | UPDATE STOK
                |---------------------------------------------------
                */
                $koleksi->update([
                    'stok' =>
                        $koleksi->stok -
                        $detail->jumlah
                ]);

                /*
                |---------------------------------------------------
                | UPDATE STATUS ITEM
                |---------------------------------------------------
                */
                $detail->update([
                    'status_item' => 'dipinjam'
                ]);
            }

            /*
            |---------------------------------------------------
            | UPDATE STATUS PEMINJAMAN
            |---------------------------------------------------
            */
            $peminjaman->update([

                'status_peminjaman' =>
                    'dipinjam'

            ]);

        });

        return redirect('/admin/peminjaman')
            ->with(
                'success',
                'Peminjaman berhasil disetujui'
            );
    }

    public function tolak($id)
    {
        $peminjaman = Peminjaman::with(
            'detail'
        )->findOrFail($id);

        if ($peminjaman->status_peminjaman != 'proses') {

            return back()->with(
                'error',
                'Peminjaman sudah diproses'
            );
        }

        foreach ($peminjaman->detail as $detail) {

            $detail->update([
                'status_item' => 'ditolak'
            ]);

        }

        $peminjaman->update([
            'status_peminjaman' => 'ditolak'
        ]);

        return back()->with(
            'success',
            'Peminjaman berhasil ditolak'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | KEMBALIKAN KOLEKSI
    |--------------------------------------------------------------------------
    */
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::with(
            'detail.koleksi'
        )->findOrFail($id);

        /*
        |---------------------------------------------------
        | VALIDASI STATUS
        |---------------------------------------------------
        */
        if (
            !in_array(
                $peminjaman->status_peminjaman,
                ['dipinjam', 'terlambat']
            )
        ) {

            return back()->with(
                'success',
                'Koleksi sudah dikembalikan'
            );
        }

        DB::transaction(function () use ($peminjaman) {

            /*
            |---------------------------------------------------
            | KEMBALIKAN STOK
            |---------------------------------------------------
            */
            foreach ($peminjaman->detail as $detail) {

                $koleksi = $detail->koleksi;

                /*
                |---------------------------------------------------
                | TAMBAH STOK
                |---------------------------------------------------
                */
                $koleksi->update([
                    'stok' => $koleksi->stok + $detail->jumlah
                ]);

                if ($detail->status_item == 'dipinjam') {

                    $detail->update([
                        'status_item' => 'dikembalikan'
                    ]);
                }
            }

            /*
            |---------------------------------------------------
            | UPDATE TOTAL DENDA
            |---------------------------------------------------
            */
            $totalDenda = $peminjaman->detail()
                ->sum('jumlah_denda');

            /*
            |---------------------------------------------------
            | UPDATE PEMINJAMAN
            |---------------------------------------------------
            */
            $peminjaman->update([

                'status_peminjaman' => 'selesai',

                'tanggal_dikembalikan' => now(),

                'total_denda' => $totalDenda,

                'denda_dibayar' => $totalDenda

            ]);
        });

        return redirect('/admin/peminjaman')
            ->with(
                'success',
                'Peminjaman berhasil diselesaikan'
            );
    }

    /*
|--------------------------------------------------------------------------
| KEMBALIKAN SATU ITEM
|--------------------------------------------------------------------------
*/
    public function kembalikanItem($id)
    {
        $detail = DetailPeminjaman::with(
            'koleksi',
            'peminjaman'
        )->findOrFail($id);

        if ($detail->status_item != 'dipinjam') {

            return back()->with(
                'error',
                'Item tidak dapat diproses'
            );
        }

        $dendaPerHari =
            $detail->koleksi->denda_harian;

        $tanggalKembali = \Carbon\Carbon::parse(
            $detail->peminjaman->tanggal_kembali
        );

        $hariTerlambat = now()->gt($tanggalKembali)
            ? now()->diffInDays($tanggalKembali)
            : 0;

        $jumlahDenda = $hariTerlambat * $dendaPerHari;

        $detail->update([

            'status_item' =>
                $hariTerlambat > 0
                ? 'terlambat'
                : 'dikembalikan',

            'jumlah_denda' =>
                $jumlahDenda
        ]);

        $detail->koleksi->increment(
            'stok',
            $detail->jumlah
        );

        $this->updateTotalDenda(
            $detail->id_peminjaman
        );

        $this->cekStatusPeminjaman(
            $detail->id_peminjaman
        );

        return back()->with(
            'success',
            $hariTerlambat > 0
            ? 'Buku terlambat. Denda Rp ' . number_format($jumlahDenda)
            : 'Buku berhasil dikembalikan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | BUKU RUSAK
    |--------------------------------------------------------------------------
    */
    public function rusakItem(Request $request, $id)
    {
        $request->validate([
            'jumlah_denda' => 'required|numeric|min:0'
        ]);

        $detail = DetailPeminjaman::with('koleksi')
            ->findOrFail($id);

        $detail->update([

            'status_item' => 'rusak',

            'jumlah_denda' => $request->jumlah_denda

        ]);

        $this->updateTotalDenda(
            $detail->id_peminjaman
        );

        $this->cekStatusPeminjaman(
            $detail->id_peminjaman
        );

        return back()->with(
            'success',
            'Buku berhasil ditandai rusak. Denda: Rp ' .
            number_format($request->jumlah_denda, 0, ',', '.')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | BUKU HILANG
    |--------------------------------------------------------------------------
    */
    public function hilangItem(Request $request, $id)
    {
        $request->validate([
            'jumlah_denda' => 'required|numeric|min:0'
        ]);

        $detail = DetailPeminjaman::with('koleksi')
            ->findOrFail($id);

        $detail->update([

            'status_item' => 'hilang',

            'jumlah_denda' => $request->jumlah_denda

        ]);

        $this->updateTotalDenda(
            $detail->id_peminjaman
        );

        $this->cekStatusPeminjaman(
            $detail->id_peminjaman
        );

        return back()->with(
            'success',
            'Buku berhasil ditandai hilang. Denda: Rp ' .
            number_format($request->jumlah_denda, 0, ',', '.')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CEK STATUS PEMINJAMAN
    |--------------------------------------------------------------------------
    */
    private function cekStatusPeminjaman($idPeminjaman)
    {
        $peminjaman = Peminjaman::with('detail')
            ->find($idPeminjaman);

        if (!$peminjaman) {
            return;
        }

        $masihDipinjam = $peminjaman->detail()
            ->where('status_item', 'dipinjam')
            ->exists();

        if (!$masihDipinjam) {

            $peminjaman->update([

                'status_peminjaman' => 'selesai',

                'tanggal_dikembalikan' => now(),

                'denda_dibayar' =>
                    $peminjaman->total_denda

            ]);
        }
    }

    public function create(Request $request)
    {
        $anggota = null;

        if ($request->filled('anggota')) {

            $anggota = AnggotaPerpustakaan::where(
                'nis',
                $request->anggota
            )
                ->orWhere(
                    'nama_lengkap',
                    'like',
                    '%' . $request->anggota . '%'
                )
                ->first();
        }

        $koleksis = Koleksi::where(
            'stok',
            '>',
            0
        )->get();

        return view(
            'admin.peminjaman.create',
            compact(
                'anggota',
                'koleksis'
            )
        );
    }

    public function storeAdmin(Request $request)
    {
        $request->validate(

            [

                'id_anggota' => 'required',

                'koleksi' => 'required|array|min:1|max:3'

            ],

            [

                'id_anggota.required' => 'Silakan pilih anggota terlebih dahulu.',

                'koleksi.required' => 'Silakan pilih minimal 1 koleksi.',

                'koleksi.array' => 'Data koleksi tidak valid.',

                'koleksi.min' => 'Silakan pilih minimal 1 koleksi.',

                'koleksi.max' => 'Maksimal hanya boleh meminjam 3 koleksi.'

            ]

        );

        DB::beginTransaction();

        try {

            $peminjaman = Peminjaman::create([

                'id_anggota' =>
                    $request->id_anggota,

                'tanggal_pinjam' =>
                    now(),

                'tanggal_kembali' =>
                    now()->addDays(7),

                'status_peminjaman' =>
                    'dipinjam'
            ]);

            foreach ($request->koleksi as $idKoleksi) {

                DetailPeminjaman::create([

                    'id_peminjaman' =>
                        $peminjaman->id_peminjaman,

                    'id_koleksi' =>
                        $idKoleksi,

                    'jumlah' => 1,

                    'status_item' =>
                        'dipinjam',

                    'jumlah_denda' => 0
                ]);

                Koleksi::where(
                    'id_koleksi',
                    $idKoleksi
                )->decrement('stok');
            }

            DB::commit();

            return redirect()
                ->route('admin.peminjaman')
                ->with(
                    'success',
                    'Peminjaman berhasil dibuat'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    public function tambah()
    {
        return view('admin.Peminjaman.create', [
            'anggota' => null,
            'koleksis' => collect()
        ]);
    }

    public function cariAnggota(Request $request)
    {
        $request->validate([
            'anggota' => 'required|string|max:100'
        ], [
            'anggota.required' => 'Silakan masukkan NIS atau nama anggota.',
            'anggota.max' => 'Pencarian terlalu panjang.'
        ]);

        $anggota = null;
        $jumlahDipinjam = 0;

        if ($request->anggota) {

            $anggota = AnggotaPerpustakaan::where(
                'nis',
                $request->anggota
            )
                ->orWhere(
                    'nama_lengkap',
                    'like',
                    '%' . $request->anggota . '%'
                )
                ->first();

            if ($anggota) {

                $jumlahDipinjam =
                    DetailPeminjaman::whereHas(
                        'peminjaman',
                        function ($q) use ($anggota) {

                            $q->where(
                                'id_anggota',
                                $anggota->id_anggota
                            )
                                ->whereIn(
                                    'status_peminjaman',
                                    [
                                        'proses',
                                        'dipinjam'
                                    ]
                                );

                        }
                    )->count();
            }
        }

        if (!$anggota) {

            $anggota = null;
            $jumlahDipinjam = 0;
            $koleksis = collect();

            $keywordAnggota = $request->anggota;

            return view(
                'admin.Peminjaman.create',
                compact(
                    'anggota',
                    'jumlahDipinjam',
                    'koleksis'
                )
            )->withErrors([
                        'anggota' => 'Anggota tidak ditemukan'
                    ]);

        }

        $keywordAnggota = $request->anggota;

        return view(
            'admin.Peminjaman.create',
            compact(
                'anggota',
                'jumlahDipinjam',
                'keywordAnggota'
            )
        );
    }

    public function cariKoleksi(Request $request)
    {
        $request->validate([
            'koleksi' => 'required|string|max:255'
        ], [
            'koleksi.required' => 'Silakan masukkan judul koleksi.'
        ]);

        $anggota = AnggotaPerpustakaan::find(
            $request->id_anggota
        );

        $jumlahDipinjam = 0;

        if ($anggota) {

            $jumlahDipinjam =
                DetailPeminjaman::whereHas(
                    'peminjaman',
                    function ($q) use ($anggota) {

                        $q->where(
                            'id_anggota',
                            $anggota->id_anggota
                        )
                            ->whereIn(
                                'status_peminjaman',
                                [
                                    'proses',
                                    'dipinjam'
                                ]
                            );

                    }
                )->count();
        }

        $koleksis = Koleksi::where(
            'judul_koleksi',
            'like',
            '%' . $request->koleksi . '%'
        )
            ->where('stok', '>', 0)
            ->get();

        if ($koleksis->isEmpty()) {

            $koleksis = collect();

            return view(
                'admin.Peminjaman.create',
                compact(
                    'anggota',
                    'koleksis',
                    'jumlahDipinjam'
                )
            )->withErrors([
                        'koleksi' => 'Koleksi tidak ditemukan'
                    ]);

        }

        return view(
            'admin.Peminjaman.create',
            compact(
                'anggota',
                'koleksis',
                'jumlahDipinjam'
            )
        );
    }

    private function updateTotalDenda($idPeminjaman)
    {
        $total = DetailPeminjaman::where(
            'id_peminjaman',
            $idPeminjaman
        )->sum('jumlah_denda');

        Peminjaman::where(
            'id_peminjaman',
            $idPeminjaman
        )->update([
                    'total_denda' => $total
                ]);
    }

}