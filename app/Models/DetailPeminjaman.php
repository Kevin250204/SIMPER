<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'detail_peminjaman';

    protected $primaryKey = 'id_detailp';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'id_peminjaman',

        'id_koleksi',

        'jumlah',

        'status_item',

        'jumlah_denda'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KE PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function peminjaman()
    {
        return $this->belongsTo(
            Peminjaman::class,
            'id_peminjaman',
            'id_peminjaman'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KE KOLEKSI
    |--------------------------------------------------------------------------
    */

    public function koleksi()
    {
        return $this->belongsTo(
            Koleksi::class,
            'id_koleksi',
            'id_koleksi'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CEK STATUS
    |--------------------------------------------------------------------------
    */

    public function isDipinjam()
    {
        return $this->status_item === 'dipinjam';
    }

    public function isDikembalikan()
    {
        return $this->status_item === 'dikembalikan';
    }

}