<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NilaiPendaftar;
use App\Models\Pendaftars;
use App\Models\Mapel;
use App\Models\BerkasPendaftar;
use Illuminate\Support\Facades\Auth;

class NilaiPendaftarController extends Controller
{
    public function index()
    {
        // $pendaftar = Pendaftars::where('user_id', Auth::id())->firstOrFail();

        //pendaftar wajib mengunggah berkas dokumennya untuk dapat lanjut ke proses ini

        $pendaftar = Pendaftars::with('berkas')->where('user_id', Auth::id())->first();

        if (!$pendaftar) {
            return back()->with('error', 'Data pendaftar tidak ditemukan.');
        }

        // Ambil jenis dokumen dan ubah ke huruf kecil semua
        $dokumenDiunggah = collect($pendaftar->berkas)
            ->pluck('jenis_berkas')
            ->map(fn($item) => strtolower($item))
            ->toArray();

        $wajib = ['foto', 'kk', 'skl'];
        $kurang = array_diff($wajib, $dokumenDiunggah);

        if (!empty($kurang)) {
            return back()->with('error', 'Dokumen wajib belum lengkap: ' . implode(', ', $kurang));
        } else {
            $nilai = $pendaftar->nilaiPendaftar()->with('mapel')->get();
            return view('dashboard.user.nilai.index', compact('nilai'));
        }
    }

    public function create()
    {
        $pendaftar = Pendaftars::where('user_id', Auth::id())->firstOrFail();
        $mapel = Mapel::where('is_active', true)->get();
        return view('dashboard.user.nilai.create', compact('mapel', 'pendaftar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pendaftar_id' => 'required|exists:pendaftars,id',
            'mapel_id' => 'required|exists:mapel,id',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        // Cek apakah sudah ada nilai mapel ini untuk pendaftar yang sama
        $existing = NilaiPendaftar::where('pendaftar_id', $request->pendaftar_id)
            ->where('mapel_id', $request->mapel_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Nilai untuk mata pelajaran ini sudah ada.');
        }

        NilaiPendaftar::create([
            'pendaftar_id' => $request->pendaftar_id,
            'mapel_id' => $request->mapel_id,
            'nilai' => $request->nilai,
        ]);

        return redirect()->route('nilai')->with('success', 'Nilai berhasil disimpan.');
    }

    public function edit($id)
    {
        $nilai = NilaiPendaftar::findOrFail($id);
        $mapel = Mapel::all();

        return view('dashboard.user.nilai.edit', compact('nilai', 'mapel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mapel_id' => 'required|exists:mapel,id',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $nilai = NilaiPendaftar::findOrFail($id);
        $nilai->update([
            'mapel_id' => $request->mapel_id,
            'nilai' => $request->nilai,
        ]);

        return redirect()->route('nilai')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $nilai = NilaiPendaftar::findOrFail($id);
        $nilai->delete();

        return back()->with('success', 'Nilai berhasil dihapus.');
    }
}
