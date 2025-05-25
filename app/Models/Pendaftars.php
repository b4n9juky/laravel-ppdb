<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftars extends Model
{
    protected $fillable = [
        'nisn',
        'nomor_pendaftaran',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'sekolah_asal',
        'alamat',
        'no_hp',
        'jalur_pendaftaran_id',
        'status',
        'user_id'
    ];
    // app/Models/Pendaftar.php

    public function berkas()
    {
        return $this->hasMany(BerkasPendaftar::class, 'pendaftar_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nilaiPendaftar()
    {
        return $this->hasMany(\App\Models\NilaiPendaftar::class, 'pendaftar_id');
    }
    public function jalur()
    {
        return $this->belongsTo(JalurPendaftaran::class, 'jalur_pendaftaran_id');
    }
    public function formulirTerisi()
    {
        return $this->nama_lengkap &&
            $this->nisn &&
            $this->jenis_kelamin &&
            $this->tempat_lahir &&
            $this->tanggal_lahir &&
            $this->alamat &&
            $this->sekolah_asal &&
            $this->no_hp &&
            $this->jalur_pendaftaran_id;
    }
    public function isLengkap()
    {
        return $this->formulirTerisi()
            && $this->nilaiPendaftar()->exists()
            && $this->berkas()->exists();
    }
}
