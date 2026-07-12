<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;

class UpdateStatusTerlambat extends Command
{
    protected $signature = 'peminjaman:cek-terlambat';
    protected $description = 'Update status peminjaman menjadi terlambat otomatis';

    public function handle()
    {
        Peminjaman::where('status_peminjaman', 'dipinjam')
            ->whereDate('tanggal_kembali', '<', now())
            ->update([
                'status_peminjaman' => 'terlambat'
            ]);

        $this->info('Status peminjaman terlambat diperbarui');
    }
}