<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPendaftaran;
use App\Models\JalurPendaftaran;
use App\Models\PengaturanPpdb;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HomePpdbController extends Controller
{
    public function index()
    {
        return view('beranda');
    }

    public function cekjadwal(Request $request)
    {
        $pengaturan = PengaturanPpdb::select('id', 'dibuka', 'ditutup')->first();

        if (!$pengaturan) {
            // return view('beranda')->with('error', 'Pengaturan belum tersedia');
            return back()->with('warning', 'Pengaturan Belum Tersedua.');
        }
        if ($request->aksi === 'register') {

            $now = Carbon::now();

            if ($now->lt($pengaturan->dibuka)) {
                // return view('beranda')->with('error', 'Pendaftaran belum dibuka');
                return back()->with('warning', 'Pendaftaran Belum dibuka.');
            }

            if ($now->gt($pengaturan->ditutup)) {
                // return view('beranda')->with('error', 'Pendaftaran telah ditutup');
                return back()->with('warning', 'Pendaftaran telah ditutup ..');
            }

            return redirect()->route('register');
        }
        if ($request->aksi === 'login') {

            $now = Carbon::now();

            if ($now->lt($pengaturan->dibuka)) {
                // return view('beranda')->with('error', 'Pendaftaran belum dibuka');
                return back()->with('warning', 'Pendaftaran Belum dibuka.');
            }

            if ($now->gt($pengaturan->ditutup)) {
                // return view('beranda')->with('error', 'Pendaftaran telah ditutup');
                return back()->with('warning', 'Pendaftaran telah ditutup ..');
            }

            return redirect()->route('login');
        }
    }
    public function loginAdmin()
    {
        return view('auth.login');
    }
}
