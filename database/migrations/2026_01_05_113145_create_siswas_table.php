<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id('id_siswa'); // PK sesuai ERD

            $table->unsignedBigInteger('id_user')->nullable(); // FK ke users

            $table->string('nis')->unique();
            $table->string('nama_lengkap');
            $table->string('kelas_siswa');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');

            $table->timestamps();

            // foreign key
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};