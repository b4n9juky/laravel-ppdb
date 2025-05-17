<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';
    protected $fillable = ['nama_mapel', 'is_active', 'created_at', 'updated_at'];
    public function nilai()
    {
        return $this->hasMany(NilaiPendaftar::class);
    }
}
