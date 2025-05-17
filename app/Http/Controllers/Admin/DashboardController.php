<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pendaftars;
use App\Models\BerkasPendaftar;
use App\Models\NilaiPendaftar;
use App\Http\Controllers\Controller;
use App\Models\Mapel;
// use App\Models\JalurPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.dashboard');
    }
    // public function datasiswa()
    // {



    //     $siswa = Pendaftars::with('nilaiPendaftar', 'berkas', 'jalur')
    //         ->withSum('nilaiPendaftar as total_nilai', 'nilai')
    //         ->withCount('berkas') // total nilai
    //         ->where('status', '<>', 'diterima')
    //         ->orderByDesc('total_nilai')
    //         ->paginate(10); // paginate langsung di sini, tanpa get()

    //     // $pendaftars = Pendaftars::withCount('berkas')->get();


    //     // $siswa = Pendaftars::with('nilaiPendaftar', 'berkas', 'jalur')
    //     //     ->withSum('nilaiPendaftar', 'nilai') // ini menjumlahkan kolom 'nilai' dari relasi nilaiPendaftar
    //     //     ->withCount('berkas') // menghitung jumlah relasi 'berkas'
    //     //     ->orderByDesc('nilai_pendaftar_sum') // urut berdasarkan hasil penjumlahan
    //     //     ->paginate(2);

    //     // $siswa = Pendaftars::with('nilaiPendaftar', 'berkas', 'jalur')
    //     //     ->withSum('nilai', 'nilai') // 'nilai' = nama relasi, 'nilai' = nama kolom
    //     //     ->withCount('berkas')
    //     //     ->orderByDesc('nilai_sum') // Laravel otomatis beri alias: nilai_sum
    //     //     ->paginate(2);


    //     return view('dashboard.admin.pendaftar.datasiswa', compact('siswa'));
    // }
    // public function showBerkas($id)
    // {
    //     $pendaftar = Pendaftars::with('berkas')->findOrFail($id);

    //     return view('dashboard.admin.pendaftar._berkas-modal', compact('pendaftar'));
    // }

    // public function status($id)
    // {
    //     $status = Pendaftars::findOrFail($id);
    //     $berkas = Pendaftars::with('berkas')->findOrFail($id);
    //     return view('dashboard.admin.pendaftar.editstatus', compact('status', 'berkas'));
    // }
    // public function update(Request $request, $id)
    // {

    //     $status_daftar = Pendaftars::findOrFail($id);

    //     $status_daftar->update([
    //         'id' => $request->id,
    //         'status' => $request->status,
    //     ]);

    //     return redirect()->route('admin.datasiswa')->with('success', 'Data berhasil diperbarui.');
    // }
    // public function editnilai($id)
    // {
    //     // $siswa = Pendaftars::findOrFail($id);
    //     // // $nilai = Pendaftars::with('nilai')->findOrFail($id);
    //     // $nilai = $siswa->nilaiPendaftar()->with('mapel')->get();


    //     $siswa = Pendaftars::findOrFail($id);

    //     $mapel = Mapel::all(); // Ambil semua mata pelajaran

    //     // Ambil nilai yang sudah ada dan ubah menjadi associative array berdasarkan id_mapel
    //     $nilai_terisi = $siswa->nilaiPendaftar->keyBy('mapel_id');

    //     return view('dashboard.admin.nilai.editnilai', compact('siswa', 'mapel', 'nilai_terisi'));

    //     // return view('dashboard.admin.nilai.editnilai', compact('siswa', 'nilai'));
    // }
    // public function updatenilai(Request $request, $id)
    // {
    //     $siswa = Pendaftars::findOrFail($id);
    //     // $nilai = Pendaftars::with('nilai')->findOrFail($id);

    //     return view('dashboard.admin.nilai.editnilai', compact('nilai'));
    // }
    // public function updateMassal(Request $request)
    // {
    //     $userId = $request->input('user_id');
    //     $nilaiInput = $request->input('nilai');
    //     foreach ($request->nilai as $id_mapel => $nilai) {
    //         NilaiPendaftar::updateOrCreate(
    //             ['pendaftar_id' => $request->user_id, 'mapel_id' => $id_mapel],
    //             ['nilai' => $nilai]
    //         );
    //     }

    //     return redirect()->back()->with('success', 'Nilai berhasil diperbarui.');
    // }
    // public function approve($id)
    // {
    //     // ambil id pendaftar
    //     $pendaftar = Pendaftars::findOrFail($id);

    //     // cek kelengkapan formulir, nilai dan berkas pendaftar

    //     if (! $pendaftar->isLengkap()) {
    //         return back()->with('error', 'Cek Kelengkapan formulir, nilai, dan berkas terlebih dahulu.');
    //     } else {

    //         // 
    //         $pendaftar = Pendaftars::with(['jalur'])->findOrFail($id);
    //         $jalur = $pendaftar->jalur;


    //         // Hitung jumlah yang sudah diterima pada jalur yang sama
    //         $jumlahDiterima = Pendaftars::where('jalurdaftar_id', $jalur->id)
    //             ->where('status', 'diterima')
    //             ->count();

    //         // Tentukan status berdasarkan kuota
    //         if ($jumlahDiterima < $jalur->kuota) {
    //             $pendaftar->status = 'diterima';
    //             $pesan = 'Pendaftar diterima karena kuota masih tersedia.';
    //         } else {
    //             $pendaftar->status = 'Cadangan';
    //             $pesan = 'Kuota penuh. Pendaftar dimasukkan ke daftar tunggu.';
    //         }


    //         $pendaftar->save();

    //         return back()->with('success', $pesan);
    //     }
    // }
    // public function batal($id)
    // {
    //     $pendaftar = Pendaftars::findOrFail($id);

    //     $pendaftar->status = 'Menunggu';
    //     $pesan = 'Status Pendaftar diubah menjadi Menunggu.';

    //     $pendaftar->save();

    //     return back()->with('success', $pesan);
    // }
}
