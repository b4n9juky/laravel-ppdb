<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftars;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\JalurPendaftaran;
use App\Models\NilaiPendaftar;
use App\Models\Mapel;
use App\Models\PengaturanPpdb;


class PendaftaranController extends Controller
{
    public function index()

    {
        // Ambil data pendaftar milik user yang sedang login dan ikut sertakan relasi 'jalur'
        $data = Pendaftars::with('jalur:id, nama_jalur')
            ->where('user_id', Auth::id())
            ->first();
        $jalur = JalurPendaftaran::all();

        if ($data) {
            // Jika pendaftar sudah ada, kirim ke halaman edit
            return view('dashboard.user.formulir.edit', compact('data', 'jalur'));
        } else {
            // Jika belum ada, tampilkan form pendaftaran
            $jalur = JalurPendaftaran::where('is_active', true)->get();

            return view('dashboard.user.formulir.form_daftar', compact('jalur'));
        }
    }

    public function store(Request $request)
    {
        // Cek apakah user sudah mendaftar
        $existing = Pendaftars::where('user_id', Auth::id())->first();

        if ($existing) {
            return redirect()->route('pendaftar.cetak', $existing->id)
                ->with('info', 'Anda sudah mengisi formulir. Silakan cetak bukti pendaftaran.');
        }

        // Validasi bisa kamu sesuaikan
        $request->validate([
            'nisn' => 'required|string|unique:pendaftars,nisn',
            // 'nomor_pendaftaran' => 'required',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'sekolah_asal' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jalurdaftar' => 'required',
        ]);
        $pendaftar = Pendaftars::create([
            'nisn' => $request->nisn,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'sekolah_asal' => $request->sekolah_asal,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'jalurdaftar_id' => $request->jalurdaftar,
            'status' => 'menunggu',
            'user_id' => Auth::id()


        ]);
        $tahun = now()->year;
        $nomorUrut = str_pad($pendaftar->id, 4, '0', STR_PAD_LEFT);
        $nomorPendaftaran = $tahun . '-' . $nomorUrut;

        // Update nomor_pendaftaran
        $pendaftar->update([
            'nomor_pendaftaran' => $nomorPendaftaran,
        ]);

        return redirect()->route('user.berkas', $pendaftar->id)
            ->with('success', 'Data berhasil disimpan');
    }
    public function cetak($id)
    {

        // $pendaftar = Pendaftars::findOrFail($id);

        $pendaftar = Pendaftars::with('jalur', 'nilaiPendaftar', 'berkas')->findOrFail($id);
        if (Auth::id() !== $pendaftar->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $atur = PengaturanPpdb::first();
        $totalNilai = $pendaftar->nilaiPendaftar->sum('nilai');
        $foto = $pendaftar->berkas->firstWhere('jenis_berkas', 'Foto'); // ambil foto


        $pdf = Pdf::loadView('dashboard.user.formulir.cetak', compact('pendaftar', 'atur', 'totalNilai', 'foto'));
        return $pdf->stream('bukti-pendaftaran.pdf');
    }


    public function updatePendaftar(Request $request, $id)
    {
        $request->validate([
            'nisn' => 'required|string|max:20',
            'nomor_pendaftaran' => 'required|string|max:50|unique:pendaftars,nomor_pendaftaran,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'sekolah_asal' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'jalurdaftar' => 'nullable|exists:jalur_pendaftarans,id',
            'status' => 'nullable|string|max:100',
        ]);

        $data = Pendaftars::findOrFail($id);
        $data->update([
            'nisn' => $request->nisn,
            'nomor_pendaftaran' => $request->nomor_pendaftaran,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'sekolah_asal' => $request->sekolah_asal,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'jalurdaftar_id' => $request->jalurdaftar,
            'status' => $request->status,
        ]);

        return redirect()->route('formulir')->with('success', 'Data berhasil diperbarui.');
    }



    public function datasiswa(Request $request)
    {


        // pencarian 



        $siswa = Pendaftars::with('nilaiPendaftar', 'berkas', 'jalur')
            ->withSum('nilaiPendaftar as total_nilai', 'nilai')
            ->withCount('berkas') // total nilai
            ->where('status', '<>', 'diterima')
            ->orderByDesc('total_nilai')
            ->paginate(10); // paginate langsung di sini, tanpa get()

        // $pendaftars = Pendaftars::withCount('berkas')->get();


        // $siswa = Pendaftars::with('nilaiPendaftar', 'berkas', 'jalur')
        //     ->withSum('nilaiPendaftar', 'nilai') // ini menjumlahkan kolom 'nilai' dari relasi nilaiPendaftar
        //     ->withCount('berkas') // menghitung jumlah relasi 'berkas'
        //     ->orderByDesc('nilai_pendaftar_sum') // urut berdasarkan hasil penjumlahan
        //     ->paginate(2);

        // $siswa = Pendaftars::with('nilaiPendaftar', 'berkas', 'jalur')
        //     ->withSum('nilai', 'nilai') // 'nilai' = nama relasi, 'nilai' = nama kolom
        //     ->withCount('berkas')
        //     ->orderByDesc('nilai_sum') // Laravel otomatis beri alias: nilai_sum
        //     ->paginate(2);

        $jalur = JalurPendaftaran::all();


        return view('dashboard.admin.pendaftar.datasiswa', compact('siswa', 'jalur'));
    }
    public function datasiswaDiterima()
    {
        $siswa = Pendaftars::with('nilaiPendaftar', 'berkas', 'jalur')
            ->withSum('nilaiPendaftar as total_nilai', 'nilai')
            ->withCount('berkas') // total nilai
            ->where('status',  'diterima')
            ->orderByDesc('total_nilai')
            ->paginate(10); // paginate langsung di sini, tanpa get()
        $jalur = JalurPendaftaran::all();
        return view('dashboard.admin.pendaftar.rekap', compact('siswa', 'jalur'));
    }

    public function search(Request $request)
    {

        $search = $request->input('query');

        $siswa = Pendaftars::with(['jalur', 'berkas'])
            ->where('nama_lengkap', 'like', "%$search%")
            ->orWhere('nisn', 'like', "%$search%")
            ->orWhere('nomor_pendaftaran', 'like', "%$search%")
            ->limit(50)
            ->get();



        // $siswa = Pendaftars::with(['nilaiPendaftar', 'berkas', 'jalur:id,nama_jalur'])
        //     ->withSum('nilaiPendaftar as total_nilai', 'nilai')
        //     ->withCount('berkas') // total nilai
        //     ->where('nama_lengkap', 'like', "%$search%")
        //     ->orWhere('nomor_pendaftaran', 'like', "%$search%")

        //     ->where('status', '<>', 'diterima') // status pendaftaran diterima
        //     ->orderByDesc('total_nilai')
        //     ->paginate(10); // paginate langsung di sini, tanpa get()

        // $jalur = JalurPendaftaran::all();


        return view('dashboard.admin.pendaftar.hasilcari', compact('siswa'));
    }


    public function showBerkas($id)
    {
        $pendaftar = Pendaftars::with('berkas')->findOrFail($id);

        return view('dashboard.admin.pendaftar._berkas-modal', compact('pendaftar'));
    }

    public function status($id)
    {
        $status = Pendaftars::findOrFail($id);
        $berkas = Pendaftars::with('berkas')->findOrFail($id);
        return view('dashboard.admin.pendaftar.editstatus', compact('status', 'berkas'));
    }
    public function update(Request $request, $id)
    {

        $status_daftar = Pendaftars::findOrFail($id);

        $status_daftar->update([
            'id' => $request->id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.datasiswa')->with('success', 'Data berhasil diperbarui.');
    }
    public function editnilai($id)
    {
        // $siswa = Pendaftars::findOrFail($id);
        // // $nilai = Pendaftars::with('nilai')->findOrFail($id);
        // $nilai = $siswa->nilaiPendaftar()->with('mapel')->get();


        $siswa = Pendaftars::findOrFail($id);

        $mapel = Mapel::all(); // Ambil semua mata pelajaran

        // Ambil nilai yang sudah ada dan ubah menjadi associative array berdasarkan id_mapel
        $nilai_terisi = $siswa->nilaiPendaftar->keyBy('mapel_id');

        return view('dashboard.admin.nilai.editnilai', compact('siswa', 'mapel', 'nilai_terisi'));

        // return view('dashboard.admin.nilai.editnilai', compact('siswa', 'nilai'));
    }
    public function updatenilai(Request $request, $id)
    {
        $siswa = Pendaftars::findOrFail($id);
        // $nilai = Pendaftars::with('nilai')->findOrFail($id);

        return view('dashboard.admin.nilai.editnilai', compact('nilai'));
    }
    public function updateMassal(Request $request)
    {
        $userId = $request->input('user_id');
        $nilaiInput = $request->input('nilai');
        foreach ($request->nilai as $id_mapel => $nilai) {
            NilaiPendaftar::updateOrCreate(
                ['pendaftar_id' => $request->user_id, 'mapel_id' => $id_mapel],
                ['nilai' => $nilai]
            );
        }

        return redirect()->back()->with('success', 'Nilai berhasil diperbarui.');
    }
    public function approve($id)
    {
        // ambil id pendaftar
        $pendaftar = Pendaftars::findOrFail($id);

        // cek kelengkapan formulir, nilai dan berkas pendaftar

        if (! $pendaftar->isLengkap()) {
            return back()->with('error', 'Cek Kelengkapan formulir, nilai, dan berkas terlebih dahulu.');
        } else {

            // 
            $pendaftar = Pendaftars::with(['jalur'])->findOrFail($id);
            $jalur = $pendaftar->jalur;


            // Hitung jumlah yang sudah diterima pada jalur yang sama
            $jumlahDiterima = Pendaftars::where('jalurdaftar_id', $jalur->id)
                ->where('status', 'diterima')
                ->count();

            // Tentukan status berdasarkan kuota
            if ($jumlahDiterima < $jalur->kuota) {
                $pendaftar->status = 'diterima';
                $pesan = 'Pendaftar diterima karena kuota masih tersedia.';
            } else {
                $pendaftar->status = 'Cadangan';
                $pesan = 'Kuota penuh. Pendaftar dimasukkan ke daftar tunggu.';
            }


            $pendaftar->save();

            return back()->with('success', $pesan);
        }
    }
    public function batal($id)
    {
        $pendaftar = Pendaftars::findOrFail($id);

        $pendaftar->status = 'Menunggu';
        $pesan = 'Status Pendaftar diubah menjadi Menunggu.';

        $pendaftar->save();

        return back()->with('success', $pesan);
    }
    public function getByJalur($jalur_id)
    {


        $siswa = Pendaftars::with('nilaiPendaftar', 'berkas', 'jalur')
            ->withSum('nilaiPendaftar as total_nilai', 'nilai')
            ->withCount('berkas')
            ->where('jalurdaftar_id', $jalur_id)
            ->orderByDesc('total_nilai')
            ->paginate(10);


        // $siswa = Pendaftars::where('jalurdaftar_id', $jalur_id)->with('jalur', 'berkas')->paginate(10);

        return view('dashboard.admin.pendaftar.partial_tabel', compact('siswa'));
    }
}
