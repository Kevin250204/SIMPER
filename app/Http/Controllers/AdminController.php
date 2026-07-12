<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function showUbahPassword()
    {
        return view('admin.password');
    }

    public function ubahPassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ]);

        $user = User::find(
            session('id_user')
        );

        if (!$user) {

            return back()->with(
                'error',
                'Session login tidak ditemukan'
            );
        }

        if (
            !Hash::check(
                $request->password_lama,
                $user->password
            )
        ) {

            return back()->with(
                'error',
                'Password lama salah'
            );
        }

        $user->password = Hash::make(
            $request->password_baru
        );

        $user->save();

        return redirect('/admin/dashboard')
            ->with(
                'success',
                'Password berhasil diubah'
            );
    }
}