<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AdminController extends Controller
{
    public function showUbahPassword()
    {
        return view('admin.password');
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

            return back()

                ->withErrors($validator)

                ->withInput();

        }

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

            return back()

                ->withErrors([

                    'password_lama' =>

                        'Password lama yang Anda masukkan salah.'

                ])

                ->withInput();
        }

        if (Hash::check($request->password_baru, $user->password)) {

            return back()

                ->withErrors([

                    'password_baru' =>

                        'Password baru tidak boleh sama dengan password lama.'

                ])

                ->withInput();

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