<?php

// app/Models/BerkasPendaftar.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BerkasPendaftar extends Model
{
    use HasFactory;
    protected $table = 'berkas_pendaftar';
    protected $fillable = ['pendaftar_id', 'jenis_berkas', 'file_path'];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftars::class);
    }
}
