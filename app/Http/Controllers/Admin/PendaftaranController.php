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
use App\Models\User;
use App\Exports\DataExport; // Import export class
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SemuaJalurExport;
use Illuminate\Support\Carbon;



use function Illuminate\Log\log;




class PendaftaranController extends Controller
{
    public function index()

    {
        // Ambil data pendaftar milik user yang sedang login dan ikut sertakan relasi 'jalur'



        $data = Pendaftars::with(['jalur:id,nama_jalur'])
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
            'jalur_pendaftaran_id' => $request->jalurdaftar,
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


        $pendaftar = Pendaftars::with('jalur', 'nilaiPendaftar', 'berkas')->findOrFail($id);
        if (Auth::id() !== $pendaftar->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $atur = PengaturanPpdb::first();
        $totalNilai = $pendaftar->nilaiPendaftar->sum('nilai');
        $foto = $pendaftar->berkas->firstWhere('jenis_berkas', 'foto'); // ambil foto


        $pdf = Pdf::loadView('dashboard.user.formulir.cetak', compact('pendaftar', 'atur', 'totalNilai', 'foto'));
        return $pdf->stream('bukti-pendaftaran.pdf');
    }
    public function cetakAdmin($id)
    {

        // $pendaftar = Pendaftars::findOrFail($id);




        $pendaftar = Pendaftars::with('jalur', 'nilaiPendaftar', 'berkas')->findOrFail($id);


        $atur = PengaturanPpdb::first();
        $totalNilai = $pendaftar->nilaiPendaftar->sum('nilai');
        $foto = $pendaftar->berkas->firstWhere('jenis_berkas', 'foto'); // ambil foto


        $pdf = Pdf::loadView('dashboard.admin.pendaftar.cetak', compact('pendaftar', 'atur', 'totalNilai', 'foto'));
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
            'jalur_pendaftaran_id' => $request->jalurdaftar,
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

    public function search(Request $request)
    {

        $search = $request->input('query');

        $siswa = Pendaftars::with(['jalur:id,nama_jalur', 'berkas'])
            ->where('nama_lengkap', 'like', "%$search%")
            ->orWhere('nisn', 'like', "%$search%")
            ->orWhere('nomor_pendaftaran', 'like', "%$search%")
            ->limit(5)
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
            $jumlahDiterima = Pendaftars::where('jalur_pendaftaran_id', $jalur->id)
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
    public function diTolak($id)
    {
        $pendaftar = Pendaftars::findOrFail($id);

        $pendaftar->status = 'Ditolak';
        $pesan = 'Status Pendaftar diubah menjadi Ditolak.';

        $pendaftar->save();

        return back()->with('success', $pesan);
    }
    public function getByJalur($jalur_id)
    {


        $siswa = Pendaftars::with('nilaiPendaftar', 'berkas', 'jalur')
            ->withSum('nilaiPendaftar as total_nilai', 'nilai')
            ->withCount('berkas')
            ->where('jalur_pendaftaran_id', $jalur_id)
            ->orderByDesc('total_nilai')
            ->paginate(10);


        // $siswa = Pendaftars::where('jalurdaftar_id', $jalur_id)->with('jalur', 'berkas')->paginate(10);

        return view('dashboard.admin.pendaftar.partial_tabel', compact('siswa'));
    }


    // datatables




    public function data(Request $request)
    {
        $search = $request->input('search.value');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $orderColumn = $request->input('order.0.column', 4);
        $orderColumnKey = $request->input("columns.$orderColumn.data");
        $orderDir = $request->input('order.0.dir', 'desc');

        // Kolom urutan sesuai frontend
        $columns = ['id', 'nama_lengkap', 'nomor_pendaftaran', 'jalur.nama_jalur', 'total_nilai', 'berkas_count', 'status', 'id'];
        $orderColumnName = $columns[$orderColumnKey] ?? 'total_nilai';



        // default ke total_nilai (index ke-4 setelah 'id')


        // Query dasar
        $query = Pendaftars::with('jalur')
            // ->withSum('nilaiPendaftar as total_nilai', 'nilai', 'status')
            ->with(['jalur', 'berkas'])->withSum('nilaiPendaftar as total_nilai', 'nilai', 'status')->withCount('berkas')
            ->where('status', '<>', 'diterima');

        // Pencarian global
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhereHas('jalur', fn($q2) => $q2->where('nama_jalur', 'like', "%{$search}%"));
            });
        }

        $recordsFiltered = $query->count();

        // Sorting
        if ($orderColumnName === 'jalur.nama_jalur') {
            $query->join('jalur', 'pendaftars.jalur_pendaftaran_id', '=', 'jalur.id')
                ->orderBy('jalur.nama_jalur', $orderDir)
                ->select('pendaftars.*', 'jalur.nama_jalur as nama_jalur');
        } else {
            $query->orderBy($orderColumnName, $orderDir);
        }

        // Pagination
        $data = $query->skip($start)->take($length)->get();

        // Format data untuk datatables
        $result = $data->map(function ($item) {
            return [
                'nama' => $item->nama_lengkap,
                'nomor_daftar' => $item->nomor_pendaftaran,
                'jalur' => $item->jalur->nama_jalur ?? '-',
                'total_nilai' => (float) $item->total_nilai ?? 0,
                // 'jumlah_berkas' => $item->berkas_count,

                'jenis_berkas' => view('dashboard.admin.pendaftar.partials.berkas', ['berkasList' => $item->berkas, 'itemId' => $item->id,])->render(),

                'status' => view('dashboard.admin.pendaftar.partials.status', [
                    'status' => $item->status
                ])->render(),
                'action' => view('dashboard.admin.pendaftar.partials.actions', ['item' => $item])->render(),
            ];
        });


        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => Pendaftars::where('status', '<>', 'diterima')->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $result,
        ]);
    }
    public function pendaftarDiterima()
    {
        $siswa = Pendaftars::with('nilaiPendaftar', 'berkas', 'jalur')
            ->withSum('nilaiPendaftar as total_nilai', 'nilai')
            ->withCount('berkas') // total nilai
            ->where('status',  'diterima')
            ->orderByDesc('total_nilai')
            ->paginate(10); // paginate langsung di sini, tanpa get()
        $jalur = JalurPendaftaran::all();
        return view('dashboard.admin.pendaftar.validasi', compact('siswa', 'jalur'));
    }



    public function dataDiterima(Request $request)
    {


        $search = $request->input('search.value');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $orderColumn = $request->input('order.0.column', 4); // default ke total_nilai
        $orderDir = $request->input('order.0.dir', 'desc');


        // Kolom urutan sesuai frontend
        $columns = ['id', 'nama_lengkap', 'nomor_pendaftaran', 'jalur.nama_jalur', 'total_nilai', 'berkas_count', 'status', 'id'];
        $orderColumnName = $columns[$orderColumn] ?? 'total_nilai';
        // $orderColumnIndex = $request->input('order.0.column', 4);
        // $orderColumnKey = $request->input("columns.$orderColumnIndex.data");
        // $orderColumnName = $columns[$orderColumnKey] ?? 'total_nilai';

        // Query utama
        $query = Pendaftars::with(['jalur', 'berkas'])
            ->withSum('nilaiPendaftar as total_nilai', 'nilai')
            ->withCount('berkas')
            ->where('status',  'diterima');

        // Pencarian global
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhereHas('jalur', fn($q2) => $q2->where('nama_jalur', 'like', "%{$search}%"));
            });
        }

        // Hitung jumlah setelah filter
        $recordsFiltered = $query->count();

        // Sorting (hanya kolom model langsung, bukan relasi)
        if ($orderColumnName !== 'jalur.nama_jalur') {
            $query->orderBy($orderColumnName, $orderDir);
        }

        // Ambil data
        $data = $query->skip($start)->take($length)->get();

        // Format untuk DataTables
        $result = $data->map(function ($item) {
            return [
                'nama' => $item->nama_lengkap,
                'nomor_daftar' => $item->nomor_pendaftaran,
                'jalur' => $item->jalur->nama_jalur ?? '-',
                'total_nilai' => $item->total_nilai ?? 0,
                'jenis_berkas' => collect($item->berkas)->map(function ($berkas) use ($item) {

                    $url = asset('storage/' . $berkas->file_path);
                    $ext = pathinfo($berkas->file_path, PATHINFO_EXTENSION);
                    if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
                        return '<a href="' . $url . '" data-lightbox="berkas-' . $item->id . '" data-title="' . e($berkas->jenis_berkas) . '">
        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 text-sm uppercase rounded mr-1 mb-1 hover:underline cursor-pointer">'
                            . e($berkas->jenis_berkas) . '</span>
    </a>';
                    } elseif (strtolower($ext) === 'pdf') {
                        return '<a href="' . $url . '" target="_blank"> <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 text-sm uppercase rounded mr-1 mb-1 hover:underline cursor-pointer">'
                            . e($berkas->jenis_berkas) . '</span></a>';
                    } else {
                        return '<a href="' . $url . '" target="_blank">Download File</a>';
                    }
                })->implode(''),
                'status' => match ($item->status) {
                    'Diterima' => '<span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 text-sm rounded">
                    <i data-feather="check-circle" class="w-4 h-4 mr-1"></i> Diterima</span>',
                    'Cadangan' => '<span class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-800 text-sm rounded">
                    <i data-feather="clock" class="w-4 h-4 mr-1"></i> Cadangan</span>',
                    'Ditolak' => '<span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 text-sm rounded">
                    <i data-feather="x-circle" class="w-4 h-4 mr-1"></i> Ditolak</span>',
                    'Menunggu' => '<span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-700 text-sm rounded">
                    <i data-feather="help-circle" class="w-4 h-4 mr-1"></i> Menunggu</span>',
                },
                'action' => '
                <div class="flex space-x-2">
                    
                    <form action="' . route('pendaftar.ditolak', $item->id) . '" method="POST" onsubmit="return confirm(\'Yakin ingin membatalkan?\')">
                        ' . csrf_field() . '<button type="submit" class="inline-flex items-center px-2 py-1 text-white bg-red-600 hover:bg-red-700 rounded text-sm">
                        <i data-feather="x-octagon" class="w-4 h-4 mr-1"></i> Batal</button>
                    </form>
                    <a href="' . route('siswa.editnilai', $item->id) . '" class="inline-flex items-center px-2 py-1 text-white bg-blue-600 hover:bg-blue-700 rounded text-sm">
                        <i data-feather="edit" class="w-4 h-4 mr-1"></i> Nilai</a>
                </div>',
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => Pendaftars::where('status', 'diterima')->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $result,
        ]);
    }
    public function pengumuman()
    {
        $waktu_pengumuman = PengaturanPpdb::select('tanggal_pengumuman')->first();
        $tanggal_pengumuman = Carbon::parse($waktu_pengumuman->tanggal_pengumuman);


        return view('pengumuman', compact('tanggal_pengumuman'));
    }
    public function pengumumanDiterima(Request $request)
    {
        $search = $request->input('search.value');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $orderColumn = $request->input('order.0.column', 1); // default ke total_nilai
        $orderDir = $request->input('order.0.dir', 'desc');

        // Kolom urutan sesuai frontend
        $columns = ['id', 'nodaftar', 'nama',  'jalur.nama_jalur', 'status'];
        $orderColumnName = $columns[$orderColumn] ?? 'nodaftar';

        // Query utama
        $query = Pendaftars::with('jalur')->where('status',  'diterima');

        // Pencarian global
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhereHas('jalur', fn($q2) => $q2->where('nama_jalur', 'like', "%{$search}%"));
            });
        }

        // Hitung jumlah setelah filter
        $recordsFiltered = $query->count();

        // Sorting (hanya kolom model langsung, bukan relasi)
        if ($orderColumnName !== 'jalur.nama_jalur') {
            $query->orderBy($orderColumnName, $orderDir);
        }

        // Ambil data
        $data = $query->skip($start)->take($length)->get();

        // Format untuk DataTables
        $result = $data->map(function ($item) {
            return [
                'nama' => $item->nama_lengkap,
                'nodaftar' => $item->nomor_pendaftaran,
                'jalur' => $item->jalur->nama_jalur ?? '-',
                'status' => $item->status

            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => Pendaftars::where('status', 'diterima')->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $result,
        ]);
    }
    public function exportToExcel()
    {
        return Excel::download(new DataExport, 'data.xlsx'); // Download file Excel
    }
    public function exportSemuaJalur()
    {
        return Excel::download(new SemuaJalurExport, 'pendaftar_per_jalur.xlsx');
    }
}
