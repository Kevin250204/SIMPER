<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    protected $table = 'stock_opname';

    protected $primaryKey = 'id_stock_opname';

    protected $fillable = [
        'id_koleksi',
        'tanggal_opname',
        'stok_sistem',
        'stok_fisik',
        'selisih',
        'jumlah_terbaru',
        'keterangan'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KE KOLEKSI
    |--------------------------------------------------------------------------
    */

    public function koleksi()
    {
        return $this->belongsTo(
            Koleksi::class,
            'id_koleksi'
        );
    }
}