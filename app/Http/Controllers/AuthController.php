<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AnggotaPerpustakaan;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // cari user
        $user = User::where(
            'username',
            $request->username
        )->first();

        // validasi login
        if (
            !$user || !Hash::check(
                $request->password,
                $user->password
            )
        ) {

            return back()
                ->withInput($request->only('username'))
                ->with(
                    'error',
                    'Username atau password salah'
                );
        }

        // cek status aktif
        if (!$user->status_aktif) {

            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Akun tidak aktif.');
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN ADMIN
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'admin') {

            session([
                'id_user' => $user->id_user,
                'username' => $user->username,
                'role' => 'admin',
            ]);

            return redirect('/admin/dashboard');
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN ANGGOTA
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'anggota') {

            $anggota = AnggotaPerpustakaan::where(
                'id_user',
                $user->id_user
            )->first();

            if (!$anggota) {

                return back()->with(
                    'error',
                    'Data anggota tidak ditemukan'
                );
            }

            session([
                'id_user' => $user->id_user,
                'id_anggota' => $anggota->id_anggota,
                'username' => $user->username,
                'nama_lengkap' => $anggota->nama_lengkap,
                'role' => 'anggota',
                'anggota_login' => true,
            ]);

            return redirect('/');
        }

        return back()->with(
            'error',
            'Role tidak valid'
        );
    }


    public function logout()
    {
        session()->flush();

        return redirect('/');
    }
}