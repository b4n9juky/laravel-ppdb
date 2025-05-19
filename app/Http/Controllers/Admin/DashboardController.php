<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pendaftars;
use App\Models\BerkasPendaftar;
use App\Models\NilaiPendaftar;
use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\JalurPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class DashboardController extends Controller
{
    public function index()
    {

        $jumlahPendaftar = Pendaftars::count();
        $kuotaPerJalur = JalurPendaftaran::select('nama_jalur', 'kuota')->get();


        $jalurs = JalurPendaftaran::withCount('jalurdaftar')->get();

        // Tambahkan kolom sisa kuota
        foreach ($jalurs as $jalur) {
            $jalur->sisa_kuota = $jalur->kuota - $jalur->jalurdaftar_count;
        }
        return view('dashboard.admin.dashboard', compact('kuotaPerJalur', 'jumlahPendaftar', 'jalurs'));
    }
}
