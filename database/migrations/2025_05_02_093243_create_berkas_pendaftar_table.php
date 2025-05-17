<?php

// database/migrations/xxxx_xx_xx_create_berkas_pendaftar_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBerkasPendaftarTable extends Migration
{
    public function up()
    {
        Schema::create('berkas_pendaftar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained()->onDelete('cascade');
            $table->string('jenis_berkas'); // contoh: kk, akta, foto
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('berkas_pendaftar');
    }
}
