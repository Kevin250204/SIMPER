<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\KategoriKoleksi;

class Koleksi extends Model
{
    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */
    use SoftDeletes;

    protected $table = 'koleksis';

    protected $primaryKey = 'id_koleksi';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'kode_koleksi',
        'id_kategori',
        'isbn',
        'judul_koleksi',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
        'denda_harian',
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

    public function kategori()
    {
        return $this->belongsTo(
            KategoriKoleksi::class,
            'id_kategori',
            'id_kategori'
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