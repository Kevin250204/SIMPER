<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\AnggotaPerpustakaan;

class AnggotaPerpustakaanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST DATA ANGGOTA
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = $request->search;

        $anggotas = AnggotaPerpustakaan::with('user')

            ->when($search, function ($query, $search) {

                $query->where(
                    'nis',
                    'like',
                    "%{$search}%"
                )

                    ->orWhere(
                        'nama_lengkap',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'kelas_anggota',
                        'like',
                        "%{$search}%"
                    );
            })

            ->orderBy('id_anggota', 'desc')
            ->paginate(10);

        return view(
            'admin.anggota.index',
            compact('anggotas')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.anggota.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE DATA
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'nis' => 'required|unique:anggota_perpustakaan,nis',
            'nama_lengkap' => 'required|string|max:255',
            'kelas_anggota' => 'required|string|max:50',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|string',

        ], [

            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',

            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan.',

            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',

            'kelas_anggota.required' => 'Kelas anggota wajib diisi.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',

            'alamat.required' => 'Alamat wajib diisi.',

        ]);

        DB::transaction(function () use ($request) {

            /*
            |--------------------------------------------------------------------------
            | SIMPAN USER
            |--------------------------------------------------------------------------
            */

            $user = User::create([

                'username' =>
                    $request->username,

                'password' =>
                    Hash::make(
                        $request->password
                    ),

                'role' => 'anggota',

                'status_aktif' => 1,
            ]);

            /*
            |--------------------------------------------------------------------------
            | SIMPAN ANGGOTA
            |--------------------------------------------------------------------------
            */

            AnggotaPerpustakaan::create([

                'id_user' =>
                    $user->id_user,

                'nis' =>
                    $request->nis,

                'nama_lengkap' =>
                    $request->nama_lengkap,

                'kelas_anggota' =>
                    $request->kelas_anggota,

                'jenis_kelamin' =>
                    $request->jenis_kelamin,

                'alamat' =>
                    $request->alamat,
            ]);
        });

        return redirect('/admin/anggota')
            ->with(
                'success',
                'Data anggota berhasil ditambahkan'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id_anggota)
    {
        $anggota = AnggotaPerpustakaan::with(
            'user'
        )->findOrFail($id_anggota);

        return view(
            'admin.anggota.edit',
            compact('anggota')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id_anggota
    ) {

        $anggota =
            AnggotaPerpustakaan::with(
                'user'
            )->findOrFail($id_anggota);

        $request->validate([

            'username' => 'required|unique:users,username,' . $anggota->user->id_user . ',id_user',

            'nis' => 'required|unique:anggota_perpustakaan,nis,' . $id_anggota . ',id_anggota',

            'nama_lengkap' => 'required|string|max:255',

            'kelas_anggota' => 'required|string|max:50',

            'jenis_kelamin' => 'required',

            'alamat' => 'required|string',

        ], [

            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',

            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah digunakan.',

            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',

            'kelas_anggota.required' => 'Kelas anggota wajib diisi.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',

            'alamat.required' => 'Alamat wajib diisi.',

        ]);

        DB::transaction(function () use ($request, $anggota) {

            /*
            |--------------------------------------------------------------------------
            | UPDATE USER
            |--------------------------------------------------------------------------
            */

            $anggota->user->update([

                'username' =>
                    $request->username,
            ]);

            /*
            |--------------------------------------------------------------------------
            | UPDATE PASSWORD
            |--------------------------------------------------------------------------
            */

            if ($request->password) {

                $anggota->user->update([

                    'password' =>
                        Hash::make(
                            $request->password
                        )
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | UPDATE ANGGOTA
            |--------------------------------------------------------------------------
            */

            $anggota->update([

                'nis' =>
                    $request->nis,

                'nama_lengkap' =>
                    $request->nama_lengkap,

                'kelas_anggota' =>
                    $request->kelas_anggota,

                'jenis_kelamin' =>
                    $request->jenis_kelamin,

                'alamat' =>
                    $request->alamat,
            ]);
        });

        return redirect('/admin/anggota')
            ->with(
                'success',
                'Data anggota berhasil diperbarui'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE DATA
    |--------------------------------------------------------------------------
    */

    public function destroy($id_anggota)
    {
        $anggota = AnggotaPerpustakaan::with([
            'user',
            'peminjaman'
        ])->findOrFail($id_anggota);

        /*
        |--------------------------------------------------------------------------
        | CEK PINJAMAN AKTIF
        |--------------------------------------------------------------------------
        */

        $masihMeminjam = $anggota->peminjaman()

            ->whereIn(
                'status_peminjaman',
                [
                    'dipinjam',
                    'terlambat'
                ]
            )

            ->exists();

        /*
        |--------------------------------------------------------------------------
        | TOLAK NONAKTIF JIKA MASIH MEMINJAM
        |--------------------------------------------------------------------------
        */

        if (
            $masihMeminjam &&
            $anggota->user->status_aktif == 1
        ) {

            return back()->with(
                'error',
                'Gagal menonaktifkan akun. Anggota masih memiliki koleksi yang sedang dipinjam atau belum dikembalikan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | AKTIFKAN / NONAKTIFKAN
        |--------------------------------------------------------------------------
        */

        $statusBaru =
            $anggota->user->status_aktif == 1
            ? 0
            : 1;

        $anggota->user->update([
            'status_aktif' => $statusBaru
        ]);

        return back()->with(
            'success',
            $statusBaru == 0
            ? 'Anggota berhasil dinonaktifkan'
            : 'Anggota berhasil diaktifkan kembali'
        );
    }
}