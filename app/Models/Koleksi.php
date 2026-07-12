<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koleksi extends Model
{
    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'koleksis';

    protected $primaryKey = 'id_koleksi';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'isbn',

        'judul_koleksi',

        'penulis',

        'penerbit',

        'tahun_terbit',

        'stok',

        'denda_harian',

        'jenis_koleksi',

        'deskripsi',

        'gambar'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KE DETAIL PEMINJAMAN
    |--------------------------------------------------------------------------
    */

    public function detailPeminjaman()
    {
        return $this->hasMany(
            DetailPeminjaman::class,
            'id_koleksi',
            'id_koleksi'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KE STOCK OPNAME
    |--------------------------------------------------------------------------
    */

    public function stockOpname()
    {
        return $this->hasMany(
            StockOpname::class,
            'id_koleksi',
            'id_koleksi'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR GAMBAR
    |--------------------------------------------------------------------------
    */

    public function getGambarUrlAttribute()
    {
        if (!$this->gambar) {
            return asset('images/no-cover.png');
        }

        return asset(
            'uploads/koleksi/' . $this->gambar
        );
    }
}