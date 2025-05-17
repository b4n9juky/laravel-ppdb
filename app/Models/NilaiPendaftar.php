<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPendaftar extends Model
{
    use HasFactory;
    protected $table = 'nilai_pendaftar';

    protected $fillable = ['pendaftar_id', 'mapel_id', 'nilai'];
    // public function pendaftar()
    // {
    //     return $this->belongsTo(Pendaftars::class);
    // }

    // public function mapel()
    // {
    //     return $this->belongsTo(Mapel::class);
    // }

    public function pendaftar()
    {
        return $this->belongsTo(\App\Models\Pendaftars::class, 'user_id');
    }

    public function mapel()
    {
        return $this->belongsTo(\App\Models\Mapel::class, 'mapel_id');
    }
}
