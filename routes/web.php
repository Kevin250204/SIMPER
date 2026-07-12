<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\KoleksiController;
use App\Http\Controllers\AnggotaPerpustakaanController;
use App\Http\Controllers\PeminjamanAdminController;
use App\Http\Controllers\PeminjamanAnggotaController;

use App\Http\Middleware\AuthSession;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', [
    LandingController::class,
    'index'
])->name('landing');

Route::get(
    '/menu-peminjaman',
    [LandingController::class, 'menuPeminjaman']
)->name('menu.peminjaman');

Route::get(
    '/admin/peminjaman/create',
    [PeminjamanAdminController::class, 'create']
)->name('admin.peminjaman.create');

Route::post(
    '/admin/peminjaman/store',
    [PeminjamanAdminController::class, 'storeAdmin']
)->name('admin.peminjaman.store');

Route::get(
    '/admin/peminjaman/tambah',
    [PeminjamanAdminController::class, 'tambah']
)->name('admin.peminjaman.tambah');

Route::get(
    '/admin/peminjaman/cari-anggota',
    [PeminjamanAdminController::class, 'cariAnggota']
)->name('admin.peminjaman.cari-anggota');

Route::get(
    '/admin/peminjaman/cari-koleksi',
    [PeminjamanAdminController::class, 'cariKoleksi']
)->name('admin.peminjaman.cari-koleksi');

Route::get(
    '/admin/ubah-password',
    [AdminController::class, 'showUbahPassword']
)->name('admin.password.form');

Route::post(
    '/admin/ubah-password',
    [AdminController::class, 'ubahPassword']
)->name('admin.password.update');

Route::get(
    '/koleksi/{id}',
    [LandingController::class, 'detailKoleksi']
)->name('koleksi.detail');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get(
    '/login',
    [AuthController::class, 'showLogin']
)->name('login');

Route::post(
    '/login',
    [AuthController::class, 'login']
);

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)->name('logout');

Route::get(
    '/logout',
    [AuthController::class, 'logout']
);

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware([
    AuthSession::class,
    RoleMiddleware::class . ':admin'
])
    ->prefix('admin')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/dashboard',
            [DashboardAdminController::class, 'index']
        )->name('admin.dashboard');

        /*
        |--------------------------------------------------------------------------
        | ANGGOTA
        |--------------------------------------------------------------------------
        */

        Route::resource(
            'anggota',
            AnggotaPerpustakaanController::class
        );

        /*
        |--------------------------------------------------------------------------
        | KOLEKSI
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/koleksi/{id_koleksi}/detail',
            [KoleksiController::class, 'detail']
        );

        Route::get(
            '/stock-opname',
            [KoleksiController::class, 'stockOpname']
        );

        Route::post(
            '/stock-opname',
            [KoleksiController::class, 'storeStockOpname']
        );

        Route::resource(
            'koleksi',
            KoleksiController::class
        );

        /*
        |--------------------------------------------------------------------------
        | PEMINJAMAN ADMIN
        |--------------------------------------------------------------------------
        */

        Route::get('/peminjaman', [PeminjamanAdminController::class, 'index'])->name('admin.peminjaman');
        Route::get('/peminjaman/{id}', [PeminjamanAdminController::class, 'detail'])->name('admin.peminjaman.detail');


        /* 
        |-------------------------------------------------------------------------- 
        | APPROVE PEMINJAMAN |
        |-------------------------------------------------------------------------- 
        */

        Route::put('/peminjaman/{id}/approve', [PeminjamanAdminController::class, 'approve'])->name('admin.peminjaman.approve');

        Route::put(
            '/peminjaman/{id}/tolak',
            [PeminjamanAdminController::class, 'tolak']
        )->name('admin.peminjaman.tolak');

        /* 
        |-------------------------------------------------------------------------- 
        | PENGEMBALIAN SATU TRANSAKSI (LAMA) |
        |-------------------------------------------------------------------------- 
        */

        Route::put('/peminjaman/{id}/kembalikan', [PeminjamanAdminController::class, 'kembalikan'])->name('admin.peminjaman.kembalikan');

        /* 
        |-------------------------------------------------------------------------- 
        | AKSI PER ITEM BUKU 
        |-------------------------------------------------------------------------- 
        */

        Route::put('/detail-peminjaman/{id}/kembalikan', [PeminjamanAdminController::class, 'kembalikanItem'])->name('admin.detail.kembalikan');
        Route::put('/detail-peminjaman/{id}/rusak', [PeminjamanAdminController::class, 'rusakItem'])->name('admin.detail.rusak');
        Route::put('/detail-peminjaman/{id}/hilang', [PeminjamanAdminController::class, 'hilangItem'])->name('admin.detail.hilang');


        Route::get(
            '/laporan',
            [LaporanController::class, 'index']
        )->name('admin.laporan');

        Route::get(
            '/laporan/pdf',
            [LaporanController::class, 'exportPdf']
        )->name('admin.laporan.pdf');

    });

/*
|--------------------------------------------------------------------------
| ANGGOTA AREA
|--------------------------------------------------------------------------
*/

Route::middleware([
    AuthSession::class,
    RoleMiddleware::class . ':anggota'
])
    ->prefix('anggota')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/peminjaman',
            [PeminjamanAnggotaController::class, 'index']
        )->name('anggota.peminjaman');

        /*
        |--------------------------------------------------------------------------
        | FORM PEMINJAMAN BARU
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/peminjaman/create',
            [PeminjamanAnggotaController::class, 'create']
        )->name('anggota.peminjaman.create');

        /*
        |--------------------------------------------------------------------------
        | SIMPAN PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/peminjaman/store',
            [PeminjamanAnggotaController::class, 'store']
        )->name('anggota.peminjaman.store');

        /*
        |--------------------------------------------------------------------------
        | RIWAYAT
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/riwayat',
            [PeminjamanAnggotaController::class, 'riwayat']
        )->name('anggota.riwayat');

        /*
        |--------------------------------------------------------------------------
        | PERPANJANG
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/perpanjang/{id}',
            [PeminjamanAnggotaController::class, 'perpanjang']
        )->name('anggota.perpanjang');
    });

Route::get(
    '/profil',
    [PeminjamanAnggotaController::class, 'profil']
)->name('anggota.profil');

Route::post(
    '/profil/password',
    [PeminjamanAnggotaController::class, 'ubahPassword']
)->name('anggota.profil.password');