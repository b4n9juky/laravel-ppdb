<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pendaftars;
use App\Models\BerkasPendaftar;
use App\Models\NilaiPendaftar;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\JalurPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {

        $jumlahPendaftar = Pendaftars::count();
        $kuotaPerJalur = JalurPendaftaran::select('id', 'kuota')->get();

        $pendaftarPerJalur = Pendaftars::select('jalur_pendaftarans.nama_jalur', DB::raw('count(*) as total'))
            ->join('jalur_pendaftarans', 'pendaftars.jalur_pendaftaran_id', '=', 'jalur_pendaftarans.id')
            ->groupBy('jalur_pendaftarans.nama_jalur')
            ->get();
        //mengambil 10 pendaftar terakhir

        $latestUsers = User::orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $jalurs = JalurPendaftaran::withCount('jalur')->get();


        // Tambahkan kolom sisa kuota
        foreach ($jalurs as $jalur) {
            $jalur->sisa_kuota = $jalur->kuota - $jalur->jalur_count;
        }
        return view('dashboard.admin.dashboard', compact(
            'kuotaPerJalur',
            'jumlahPendaftar',
            'pendaftarPerJalur',
            'jalurs',
            'latestUsers'
        ));
    }
    public function dashboard()
    {
        // Ambil data pendaftar per jalur
        $pendaftarPerJalur = Pendaftars::select('jalurdaftar_id', DB::raw('count(*) as total'))
            ->groupBy('jalurdaftar_id')
            ->get();

        return view('admin.dashboard', compact('pendaftarPerJalur'));
    }
}
