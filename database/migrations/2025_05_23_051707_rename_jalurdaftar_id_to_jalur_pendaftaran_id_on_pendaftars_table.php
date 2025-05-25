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

        Schema::table('pendaftars', function (Blueprint $table) {
            // 1. Drop foreign key dulu (nama foreign key biasanya pakai konvensi)
            $table->dropForeign(['jalurdaftar_id']);

            // 2. Rename kolom
            $table->renameColumn('jalurdaftar_id', 'jalur_pendaftaran_id');

            // 3. Tambah foreign key baru ke kolom yang sudah diganti nama
            $table->foreign('jalur_pendaftaran_id')
                ->references('id')
                ->on('jalur_pendaftarans')
                ->onDelete('cascade');  // sesuaikan tindakan onDelete
        });
    }

    public function down(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            // Balik prosesnya

            $table->dropForeign(['jalur_pendaftaran_id']);

            $table->renameColumn('jalur_pendaftaran_id', 'jalurdaftar_id');

            $table->foreign('jalurdaftar_id')
                ->references('id')
                ->on('jalur_pendaftarans')
                ->onDelete('cascade');
        });
    }
};
