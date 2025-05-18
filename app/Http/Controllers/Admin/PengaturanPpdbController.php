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
        ]);

        $setting = PengaturanPpdb::findOrFail($id);
        $setting->nama_sekolah = $request->nama_sekolah;
        $setting->alamat_sekolah = $request->alamat_sekolah;
        $setting->kota = $request->kota;
        $setting->kontak = $request->kontak;
        $setting->nama_kepsek = $request->nama_kepsek;
        $setting->dibuka = $request->dibuka;
        $setting->ditutup = $request->ditutup;
        $setting->logo_sekolah = $request->logo_sekolah;
        $setting->tanda_tangan = $request->tanda_tangan;
        $setting->kop_surat = $request->kop_surat;


        $folder = 'kop_surat';

        // Hapus semua file yang ada di folder kop_surat
        if ($request->hasFile('kop_surat')) {
            $files = Storage::disk('public')->files($folder);
            foreach ($files as $file) {
                Storage::disk('public')->delete($file);
            }



            // Simpan file baru dengan nama tetap (opsional)
            $file = $request->file('kop_surat');
            $filename = 'kop_surat.' . $file->getClientOriginalExtension(); // misalnya kop_surat.jpg
            $path = $file->storeAs($folder, $filename, 'public');



            //     // Hapus file lama jika ada
            //     if ($setting->kop_surat && Storage::exists('public/' . $setting->kop_surat)) {
            //         Storage::delete('public/' . $setting->kop_surat);
            //     }

            //     // Simpan file baru
            //     $file = $request->file('kop_surat');
            //     $filename = time() . '_' . $file->getClientOriginalName();

            //     // Simpan file ke storage/app/public/kop_surat
            //     Storage::disk('public')->putFileAs('kop_surat', $file, $filename);

            //     // Simpan path relatif ke database
            $setting->kop_surat = 'kop_surat/' . $filename;
            // }

            $setting->save();

            return back()->with('pesan', 'Berhasil Di Update');
        } else {
            $setting->save();
            return back()->with('pesan', 'Berhasil Di Update');
        }
    }

    public function destroy($id) {}
}
