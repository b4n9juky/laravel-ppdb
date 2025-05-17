<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->string('nisn')->unique();
            $table->string('nomor_pendaftaran')->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('sekolah_asal');
            $table->text('alamat');
            $table->string('no_hp');
            $table->enum('jalur_pendaftaran', ['reguler', 'prestasi', 'afirmasi', 'luar kota', 'anak guru', 'tahfidz']);
            $table->enum('status', ['Menunggu', 'Diterima', 'Ditolak', 'Cadangan'])->default('Menunggu');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};
