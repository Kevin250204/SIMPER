<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'id_anggota',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status_peminjaman',
        'total_denda'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KE ANGGOTA
    |--------------------------------------------------------------------------
    */

    public function anggota()
    {
        return $this->belongsTo(
            AnggotaPerpustakaan::class,
            'id_anggota'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KE DETAIL PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function detail()
    {
        return $this->hasMany(
            DetailPeminjaman::class,
            'id_peminjaman'
        );
    }
}