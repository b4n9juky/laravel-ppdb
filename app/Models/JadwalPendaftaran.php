<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPendaftaran extends Model
{
    use HasFactory;
    protected $table = 'jadwal_pendaftaran';

    protected $fillable = [
        'jalurpendaftaran_id',
        'dibuka_pada',
        'ditutup_pada',
        'created_at',
        'updated_at',
    ];
    public function jalur()
    {
        return $this->belongsTo(JalurPendaftaran::class, 'jalurpendaftaran_id');
    }

    public function isOpen(): bool
    {
        return now()->between($this->dibuka_pada, $this->ditutup_pada);
    }
}
