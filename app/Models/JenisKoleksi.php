<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKoleksi extends Model
{
    protected $table = 'jenis_koleksi';

    protected $primaryKey = 'id_jenis';

    protected $fillable = [
        'nama_jenis'
    ];

    public $timestamps = true;

    public function kategori()
    {
        return $this->hasMany(
            KategoriKoleksi::class,
            'id_jenis',
            'id_jenis'
        );
    }
}