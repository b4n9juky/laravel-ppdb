<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JalurPendaftaran extends Model
{
    protected $table = 'jalur_pendaftarans';
    protected $fillable = ['nama_jalur', 'kuota', 'is_active', 'created_at', 'updated_at'];
    public function jalurdaftar()
    {
        return $this->hasMany(Pendaftars::class, 'jalurdaftar_id');
    }
    public function jadwal()
    {
        return $this->hasMany(JadwalPendaftaran::class, 'jalurpendaftaran_id');
    }
}
