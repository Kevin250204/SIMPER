<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

use App\Models\Koleksi;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Carbon\Carbon;
use App\Models\JenisKoleksi;



class PeminjamanAnggotaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN PEMINJAMAN ANGGOTA
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {

        DetailPeminjaman::where('status_item', 'dipinjam')
            ->whereHas('peminjaman', function ($q) {

                $q->whereDate(
                    'tanggal_kembali',
                    '<',
                    Carbon::today()
                );

            })
            ->update([
                'status_item' => 'terlambat'
            ]);

        $aktif = Peminjaman::with([
            'detail' => function ($q) {

                $q->whereIn(
                    'status_item',
                    ['dipinjam', 'terlambat']
                );

            },
            'detail.koleksi'
        ])
            ->where(
                'id_anggota',
                session('id_anggota')
            )
            ->where(
                'status_peminjaman',
                'dipinjam'
            )
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | HITUNG SISA HARI PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        foreach ($aktif as $item) {

            $tanggalKembali =
                Carbon::parse(
                    $item->tanggal_kembali
                )->startOfDay();

            $hariIni =
                Carbon::now()
                    ->startOfDay();

            $item->sisa_hari =
                $hariIni->diffInDays(
                    $tanggalKembali,
                    false
                );
        }

        $riwayatQuery = DetailPeminjaman::with([
            'koleksi',
            'peminjaman'
        ])
            ->whereHas('peminjaman', function ($q) {

                $q->where(
                    'id_anggota',
                    session('id_anggota')
                );

            });

        $riwayat = DetailPeminjaman::with([
            'koleksi',
            'peminjaman'
        ])
            ->whereHas('peminjaman', function ($q) {

                $q->where(
                    'id_anggota',
                    session('id_anggota')
                );

            })
            ->when($request->filled('search'), function ($query) use ($request) {

                $query->whereHas('koleksi', function ($q) use ($request) {

                    $q->where(
                        'judul_koleksi',
                        'like',
                        '%' . $request->search . '%'
                    );

                });

            })

            ->when($request->filled('status'), function ($query) use ($request) {

                $query->where(
                    'status_item',
                    $request->status
                );

            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $jumlahStatus = [

            'semua' => DetailPeminjaman::whereHas('peminjaman', function ($q) {
                $q->where('id_anggota', session('id_anggota'));
            })->count(),

            'dikembalikan' => DetailPeminjaman::whereHas('peminjaman', function ($q) {
                $q->where('id_anggota', session('id_anggota'));
            })->where('status_item', 'dikembalikan')->count(),

            'terlambat' => DetailPeminjaman::whereHas('peminjaman', function ($q) {
                $q->where('id_anggota', session('id_anggota'));
            })->where('status_item', 'terlambat')->count(),

            'ditolak' => DetailPeminjaman::whereHas('peminjaman', function ($q) {
                $q->where('id_anggota', session('id_anggota'));
            })->where('status_item', 'ditolak')->count(),

            'hilang' => DetailPeminjaman::whereHas('peminjaman', function ($q) {
                $q->where('id_anggota', session('id_anggota'));
            })->where('status_item', 'hilang')->count(),

            'rusak' => DetailPeminjaman::whereHas('peminjaman', function ($q) {
                $q->where('id_anggota', session('id_anggota'));
            })->where('status_item', 'rusak')->count(),
        ];


        return view(
            'anggota.peminjaman',
            compact(
                'aktif',
                'riwayat',
                'jumlahStatus'
            )
        );
    }
    /*
    |--------------------------------------------------------------------------
    | FORM PEMINJAMAN BARU
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {

        $idAnggota = session('id_anggota');

        $masihAdaTerlambat = DetailPeminjaman::where('status_item', 'terlambat')
            ->whereHas('peminjaman', function ($q) use ($idAnggota) {
                $q->where('id_anggota', $idAnggota)
                    ->where('status_peminjaman', 'dipinjam');
            })
            ->exists();

        if ($masihAdaTerlambat) {
            return redirect()
                ->route('anggota.peminjaman')
                ->with(
                    'error',
                    'Tidak dapat melakukan peminjaman karena masih terdapat koleksi yang terlambat dan belum dikembalikan.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | KOLEKSI YANG SUDAH DIPINJAM / DIAJUKAN
        |--------------------------------------------------------------------------
        */

        $koleksiTidakBolehDipilih = DB::table('detail_peminjaman')
            ->join(
                'peminjaman',
                'detail_peminjaman.id_peminjaman',
                '=',
                'peminjaman.id_peminjaman'
            )
            ->where(
                'peminjaman.id_anggota',
                $idAnggota
            )
            ->whereIn(
                'peminjaman.status_peminjaman',
                ['proses', 'dipinjam']
            )
            ->pluck('detail_peminjaman.id_koleksi')
            ->toArray();

        $jumlahPinjamanAktif = DetailPeminjaman::whereHas(
            'peminjaman',
            function ($q) {
                $q->where(
                    'id_anggota',
                    session('id_anggota')
                );
            }
        )
            ->whereIn(
                'status_item',
                [
                    'menunggu',
                    'dipinjam'
                ]
            )
            ->count();

        if ($jumlahPinjamanAktif >= 3) {

            return redirect()
                ->route('anggota.peminjaman')
                ->with(
                    'error',
                    'Anda sudah mencapai batas maksimal peminjaman (3 koleksi)'
                );
        }


        $query = Koleksi::query();

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where(
                    'judul_koleksi',
                    'like',
                    '%' . $request->search . '%'
                )
                    ->orWhere(
                        'penulis',
                        'like',
                        '%' . $request->search . '%'
                    )
                    ->orWhere(
                        'penerbit',
                        'like',
                        '%' . $request->search . '%'
                    );
            });
        }

        if ($request->filled('jenis') && $request->jenis != 'semua') {

            $query->whereHas('kategori.jenis', function ($q) use ($request) {

                $q->where('nama_jenis', $request->jenis);

            });

        }

        $koleksis = $query
            ->where('stok', '>', 0)
            ->whereNotIn(
                'id_koleksi',
                $koleksiTidakBolehDipilih
            )
            ->paginate(10)
            ->withQueryString();

        $jenisKoleksi = JenisKoleksi::orderBy('nama_jenis')
            ->pluck('nama_jenis');

        return view(
            'anggota.peminjaman-create',
            compact(
                'koleksis',
                'jenisKoleksi',
                'koleksiTidakBolehDipilih',
                'jumlahPinjamanAktif'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'koleksi' => 'required|array|min:1|max:3',
            'koleksi.*' => 'exists:koleksis,id_koleksi'
        ]);

        $request->merge([
            'koleksi' => array_unique($request->koleksi)
        ]);

        $idAnggota = session('id_anggota');

        $masihAdaTerlambat = DetailPeminjaman::where('status_item', 'terlambat')
            ->whereHas('peminjaman', function ($q) use ($idAnggota) {
                $q->where('id_anggota', $idAnggota)
                    ->where('status_peminjaman', 'dipinjam');
            })
            ->exists();

        if ($masihAdaTerlambat) {
            return back()->with(
                'error',
                'Tidak dapat melakukan peminjaman karena masih terdapat koleksi yang terlambat dan belum dikembalikan.'
            );
        }

        $totalAktif = DB::table('detail_peminjaman')
            ->join(
                'peminjaman',
                'detail_peminjaman.id_peminjaman',
                '=',
                'peminjaman.id_peminjaman'
            )
            ->where(
                'peminjaman.id_anggota',
                $idAnggota
            )
            ->whereIn(
                'peminjaman.status_peminjaman',
                ['proses', 'dipinjam']
            )
            ->count();

        if (
            ($totalAktif + count($request->koleksi))
            > 3
        ) {

            return back()->with(
                'error',
                'Maksimal hanya boleh meminjam 3 koleksi.'
            );
        }

        $koleksiSudahAktif = DB::table('detail_peminjaman')
            ->join(
                'peminjaman',
                'detail_peminjaman.id_peminjaman',
                '=',
                'peminjaman.id_peminjaman'
            )
            ->where(
                'peminjaman.id_anggota',
                session('id_anggota')
            )
            ->whereIn(
                'peminjaman.status_peminjaman',
                ['proses', 'dipinjam']
            )
            ->pluck('detail_peminjaman.id_koleksi')
            ->toArray();

        foreach ($request->koleksi as $idKoleksi) {

            if (
                in_array(
                    $idKoleksi,
                    $koleksiSudahAktif
                )
            ) {

                return back()->with(
                    'error',
                    'Koleksi sudah dipinjam atau sedang diajukan.'
                );
            }
        }

        $jumlahValid = 0;

        foreach ($request->koleksi as $idKoleksi) {

            $koleksi = Koleksi::find($idKoleksi);

            if (
                $koleksi &&
                $koleksi->stok > 0
            ) {
                $jumlahValid++;
            }
        }

        if ($jumlahValid == 0) {

            return back()->with(
                'error',
                'Tidak ada koleksi yang dapat dipinjam.'
            );
        }

        DB::beginTransaction();

        try {

            $peminjaman = Peminjaman::create([

                'id_anggota' =>
                    session('id_anggota'),

                'tanggal_pinjam' =>
                    now()->format('Y-m-d'),

                'tanggal_kembali' =>
                    now()
                        ->addDays(7)
                        ->format('Y-m-d'),

                'status_peminjaman' =>
                    'proses'
            ]);

            foreach ($request->koleksi as $idKoleksi) {

                $koleksi = Koleksi::find($idKoleksi);

                if (!$koleksi) {
                    continue;
                }

                if ($koleksi->stok <= 0) {
                    continue;
                }

                DetailPeminjaman::create([

                    'id_peminjaman' =>
                        $peminjaman->id_peminjaman,

                    'id_koleksi' =>
                        $koleksi->id_koleksi,

                    'jumlah' => 1,

                    'status_item' =>
                        'menunggu',

                    'jumlah_denda' => 0
                ]);
            }

            DB::commit();

            return redirect()
                ->route('anggota.peminjaman')
                ->with(
                    'success',
                    'Pengajuan peminjaman berhasil dikirim'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RIWAYAT PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function riwayat()
    {
        $peminjamans = Peminjaman::with([
            'detail.koleksi'
        ])
            ->where(
                'id_anggota',
                session('id_anggota')
            )
            ->latest()
            ->paginate(10);

        return view(
            'anggota.riwayat',
            compact(
                'peminjamans'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PERPANJANG PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function perpanjang($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->sudah_diperpanjang == 1) {

            return back()->with(
                'error',
                'Peminjaman hanya dapat diperpanjang satu kali.'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI PEMILIK PEMINJAMAN
        |--------------------------------------------------------------------------
        */
        if (
            $peminjaman->id_anggota
            != session('id_anggota')
        ) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | HANYA BOLEH DIPERPANJANG JIKA STATUS DIPINJAM
        |--------------------------------------------------------------------------
        */
        if (
            $peminjaman->status_peminjaman
            != 'dipinjam'
        ) {

            return back()->with(
                'error',
                'Peminjaman tidak dapat diperpanjang.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | TAMBAH 7 HARI DARI TANGGAL KEMBALI LAMA
        |--------------------------------------------------------------------------
        */
        $tanggalKembaliBaru =
            Carbon::parse(
                $peminjaman->tanggal_kembali
            )->addDays(7);

        $peminjaman->sudah_diperpanjang = 1;

        $peminjaman->update([

            'tanggal_kembali' =>
                $tanggalKembaliBaru->format('Y-m-d')
        ]);

        return back()->with(
            'success',
            'Peminjaman berhasil diperpanjang 7 hari'
        );
    }

    public function profil()
    {
        /*
   |--------------------------------------------------------------------------
   | CEK LOGIN ANGGOTA
   |--------------------------------------------------------------------------
   */
        if (
            !session()->has('id_anggota') ||
            session('role') != 'anggota'
        ) {

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Silakan login terlebih dahulu'
                );
        }

        $idAnggota = session('id_anggota');

        /*
        |--------------------------------------------------------------------------
        | TOTAL DENDA SUDAH DIBAYAR
        |--------------------------------------------------------------------------
        */

        $totalDibayar = DetailPeminjaman::whereHas(
            'peminjaman',
            function ($q) use ($idAnggota) {

                $q->where(
                    'id_anggota',
                    $idAnggota
                )
                    ->where(
                        'status_peminjaman',
                        'selesai'
                    );

            }
        )->sum('jumlah_denda');

        /*
        |--------------------------------------------------------------------------
        | TOTAL DENDA BELUM DIBAYAR
        |--------------------------------------------------------------------------
        */

        $belumDibayar = DetailPeminjaman::whereHas(
            'peminjaman',
            function ($q) use ($idAnggota) {

                $q->where(
                    'id_anggota',
                    $idAnggota
                )
                    ->where(
                        'status_peminjaman',
                        'dipinjam'
                    );

            }
        )
            ->where(
                'status_item',
                'terlambat'
            )
            ->sum('jumlah_denda');

        return view(
            'anggota.profil.index',
            compact(
                'totalDibayar',
                'belumDibayar'
            )
        );
    }

    public function ubahPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->to(url()->previous() . '#ubah-password')
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil user yang sedang login dari session
        $user = User::find(session('id_user'));

        // Pastikan user masih ada
        if (!$user) {
            return back()->with(
                'error',
                'Data pengguna tidak ditemukan.'
            );
        }

        // Cek password lama
        if (
            !Hash::check(
                $request->password_lama,
                $user->password
            )
        ) {

            return redirect()
                ->to(url()->previous() . '#ubah-password')
                ->withErrors([
                    'password_lama' => 'Password lama yang Anda masukkan salah.'
                ])
                ->withInput();
        }

        if (Hash::check($request->password_baru, $user->password)) {
            return redirect()
                ->to(url()->previous() . '#ubah-password')
                ->withErrors([
                    'password_baru' => 'Password baru tidak boleh sama dengan password lama.'
                ])
                ->withInput();
        }

        // Simpan password baru
        $user->password = Hash::make(
            $request->password_baru
        );

        $user->save();

        return redirect()
            ->to(url()->previous() . '#ubah-password')
            ->with(
                'success',
                'Password berhasil diubah.'
            );
    }
}