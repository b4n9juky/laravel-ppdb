<?php

// app/Http/Controllers/BerkasPendaftarController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\BerkasPendaftar;
use App\Models\Pendaftars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BerkasPendaftarController extends Controller
{

    public function index()

    {



        $pendaftar = Pendaftars::where('user_id', Auth::id())->first();




        // $nilai = $pendaftar->nilaiPendaftar()->with('mapel')->get();
        // Ambil pendaftar berdasarkan user yang sedang login
        // $pendaftar = Pendaftars::where('id', Auth::id())->first();
        // Jika belum mengisi formulir
        if (!$pendaftar) {
            return redirect()->route('user.dashboard')->with('error', 'Anda belum mengisi formulir pendaftaran.');
        } else {

            // Ambil semua berkas milik pendaftar
            $berkas = $pendaftar->berkas; // pastikan relasi `berkas()` ada di model Pendaftars

            return view('dashboard.user.berkas.index', compact('berkas'));
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'pendaftar_id' => 'required|exists:pendaftars,id',
            'jenis_berkas' => 'required|string',
            'file' => 'required|file|mimetypes:application/pdf,image/jpeg|max:2048',
        ]);

        $path = $request->file('file')->store('berkas_pendaftar', 'public');

        BerkasPendaftar::create([
            'pendaftar_id' => $request->pendaftar_id,
            'jenis_berkas' => $request->jenis_berkas,
            'file_path' => $path,
        ]);

        return back()->with('success', 'Berkas berhasil diupload.');
    }

    public function destroy($id)
    {


        $berkas = BerkasPendaftar::findOrFail($id);

        $filePath = 'public/' . $berkas->file_path;

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }

        // Tambahan perlindungan jika Storage gagal
        $fullPath = storage_path('app/public/' . $berkas->file_path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $berkas->delete();

        return back()->with('success', 'Berkas berhasil dihapus.');
    }
}
