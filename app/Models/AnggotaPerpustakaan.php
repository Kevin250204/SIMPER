<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaPerpustakaan extends Model
{
    protected $table = 'anggota_perpustakaan';

    protected $primaryKey = 'id_anggota';

    protected $fillable = [
        'id_user',
        'nis',
        'nama_lengkap',
        'kelas_anggota',
        'jenis_kelamin',
        'alamat'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KE USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KE PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function peminjaman()
    {
        return $this->hasMany(
            Peminjaman::class,
            'id_anggota'
        );
    }
}