<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JalurPendaftaran;
use App\Models\JadwalPendaftaran;
use App\Models\PengaturanPpdb;
use Illuminate\Support\Facades\Storage;




class PengaturanPpdbController extends Controller
{
    // berisi pengaturan tentang ppdb
    // misal nama sekolah / madrasah
    // logo madrasah
    // alamat madrasah
    // format cetak bukti pendaftaran
    // nama kepala sekolah / atau panitia
    // tempat upload kop surat
    public function index()
    {
        $jalurs = JalurPendaftaran::all(); // ambil semua jalur
        $jadwals = JadwalPendaftaran::with('jalur')->get(); // relasi eager loading
        $settings = PengaturanPpdb::first(); // ambil pengaturan ppdb

        // return view('jadwal.index', compact('jalurs', 'jadwals'));
        return view('dashboard.admin.pengaturan.index', compact('jalurs', 'jadwals', 'settings'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'jalur_id' => 'required|exists:jalur_pendaftarans,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tanggal_pengumuman' => 'required|date',
        ]);

        JadwalPendaftaran::create([
            'jalurpendaftaran_id' => $request->jalur_id,
            'dibuka_pada' => $request->tanggal_mulai,
            'ditutup_pada' => $request->tanggal_selesai,
        ]);

        return response()->json(['success' => 'Jadwal berhasil ditambahkan.']);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'jalur_id' => 'required|exists:jalur_pendaftarans,id',
            'dibuka_pada' => 'required|date',
            'ditutup_pada' => 'required|date|after_or_equal:dibuka_pada',
        ]);

        $jadwal = JadwalPendaftaran::findOrFail($id);
        $jadwal->update([
            'jalurpendaftaran_id' => $request->jalur_id,
            'dibuka_pada' => $request->dibuka_pada,
            'ditutup_pada' => $request->ditutup_pada,
            'tanggal_pengumuman' => $request->tanggal_pengumuman,
        ]);

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }
    public function updateData(Request $request, $id)
    {



        $request->validate([
            'nama_sekolah' => 'required',
            'alamat_sekolah' => 'required',
            'kota' => 'required',
            'kontak' => 'required|string',
            'nama_kepsek' => 'required',
            'logo_sekolah' => 'nullable|file|image',
            'kop_surat' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'tanda_tangan' => 'nullable|file|image',
            'dibuka' => 'required',
            'ditutup' => 'required|date|after_or_equal:dibuka',
            'tanggal_pengumuman' => 'required|date',
        ]);

        $setting = PengaturanPpdb::findOrFail($id);
        $setting->nama_sekolah = $request->nama_sekolah;
        $setting->alamat_sekolah = $request->alamat_sekolah;
        $setting->kota = $request->kota;
        $setting->kontak = $request->kontak;
        $setting->nama_kepsek = $request->nama_kepsek;
        $setting->dibuka = $request->dibuka;
        $setting->ditutup = $request->ditutup;
        $setting->tanggal_pengumuman = $request->tanggal_pengumuman;

        // Upload logo_sekolah jika ada
        if ($request->hasFile('logo_sekolah')) {
            if ($setting->logo_sekolah && Storage::disk('public')->exists($setting->logo_sekolah)) {
                Storage::disk('public')->delete($setting->logo_sekolah);
            }

            $path = $request->file('logo_sekolah')->store('logo_sekolah', 'public');
            $setting->logo_sekolah = $path;
        }

        // Upload tanda_tangan jika ada
        if ($request->hasFile('tanda_tangan')) {
            if ($setting->tanda_tangan && Storage::disk('public')->exists($setting->tanda_tangan)) {
                Storage::disk('public')->delete($setting->tanda_tangan);
            }

            $path = $request->file('tanda_tangan')->store('tanda_tangan', 'public');
            $setting->tanda_tangan = $path;
        }

        // Upload kop_surat jika ada
        if ($request->hasFile('kop_surat')) {
            if ($setting->kop_surat && Storage::disk('public')->exists($setting->kop_surat)) {
                Storage::disk('public')->delete($setting->kop_surat);
            }

            $path = $request->file('kop_surat')->store('kop_surat', 'public');
            $setting->kop_surat = $path;
        }

        $setting->save();

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id) {}
}
