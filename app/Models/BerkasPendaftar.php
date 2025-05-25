<?php

// app/Models/BerkasPendaftar.php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
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
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($berkas) {
            if ($berkas->nama_file && Storage::exists($berkas->nama_file)) {
                Storage::delete($berkas->nama_file);
            }
        });
    }
}
