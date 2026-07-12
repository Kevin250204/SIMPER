<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'password',
        'role',
        'status_aktif',
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = true;

    public function anggota()
    {
        return $this->hasOne(
            AnggotaPerpustakaan::class,
            'id_user'
        );
    }
}