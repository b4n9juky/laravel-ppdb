<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class PengaturanPpdb extends Model
{
    use HasFactory;
    protected $table = 'pengaturan_ppdb';

    protected $fillable = [
        'nama_sekolah',
        'alamat_sekolah',
        'kota',
        'kontak',
        'nama_kepsek',
        'logo_sekolah',
        'kop_surat',
        'tanda_tangan',
        'dibuka',
        'ditutup'

    ];
    protected $casts = [
        'dibuka' => 'datetime',
        'ditutup' => 'datetime',
    ];
    // public function isOpen(): bool
    // {
    //     if (!$this->dibuka || !$this->ditutup) {
    //         return false;
    //     }

    //     return now()->between($this->dibuka, $this->ditutup);
    // }
    // public function scopeOpen(Builder $query)
    // {
    //     $now = \Carbon\Carbon::now();
    //     return $query->where('dibuka', '<=', $now)
    //         ->where('ditutup', '>=', $now);
    // }
}
