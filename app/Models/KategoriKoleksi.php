<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Koleksi;

class KategoriKoleksi extends Model
{
    protected $table = 'kategori_koleksi';

    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'id_jenis',
        'nama_kategori'
    ];

    public $timestamps = true;

    public function jenis()
    {
        return $this->belongsTo(
            JenisKoleksi::class,
            'id_jenis',
            'id_jenis'
        );
    }

    public function koleksi()
    {
        return $this->hasMany(Koleksi::class, 'id_kategori', 'id_kategori');
    }
}