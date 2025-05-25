<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\BerkasPendaftarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NilaiPendaftarController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JalurPendaftaranController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\JadwalPendaftaranController;
use App\Http\Controllers\Admin\PengaturanPpdbController;
use App\Http\Controllers\HomePpdbController;
use App\Http\Controllers\Admin\AdminUserController;

// Route::get('/', function () {
//     return view('welcome');
// });

//route buka tutup pendaftaran
Route::get('/', [HomePpdbController::class, 'index'])->name('welcome');
Route::get('/welcome', [HomePpdbController::class, 'cekjadwal'])->name('masuk');
Route::get(
    '/login/{tanggal}',
    function ($tanggal) {
        if ($tanggal !== now()->format('Y-m-d')) {
            abort(404);
        }
        return view('auth.login', ['tanggal' => $tanggal]);
    }
);
Route::get('/pengumuman', [PendaftaranController::class, 'pengumuman'])->name('pengumuman');
Route::get('/pengumuman/hasil', [PendaftaranController::class, 'pengumumanDiterima'])->name('pengumuman.diterima');


// Route::get(
//     '/2025',
//     [HomePpdbController::class, 'loginAdmin']
// )->name('admin.login');

// Route::middleware('check.time')->group(function () {
//     Route::get('/pendaftaran', [PendaftaranController::class, 'index']);
//     Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
//     Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
// });


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/datasiswa', [PendaftaranController::class, 'datasiswa'])->name('admin.datasiswa');
    Route::get('/admin/cetak/{id}', [PendaftaranController::class, 'cetakAdmin'])->name('admin.cetak');
    //rute pendaftaran
    // Route::get('/datasiswa', [PendaftaranController::class, 'datasiswa'])->name('admin.datasiswa');
    Route::post('/datasiswa/{id}/batal', [PendaftaranController::class, 'batal'])->name('pendaftar.batal');
    Route::get('/datasiswa/{id}/status', [PendaftaranController::class, 'status'])->name('siswa.status');
    Route::put('/datasiswa/{id}/update', [PendaftaranController::class, 'update'])->name('status.update');
    Route::get('/datasiswa/{id}', [PendaftaranController::class, 'editnilai'])->name('siswa.editnilai');
    Route::put('/datasiswa/{id}', [PendaftaranController::class, 'updatenilai'])->name('siswa.updatenilai');
    Route::post('/datasiswa/update-massal', [PendaftaranController::class, 'updateMassal'])->name('nilai.updateMassal');
    Route::get('/admin/pendaftar/{id}/berkas', [PendaftaranController::class, 'showBerkas']);
    Route::post('/datasiswa/{id}/approve', [PendaftaranController::class, 'approve'])->name('pendaftar.approve');
    Route::get('/siswa/by-jalur/{jalur_id}', [PendaftaranController::class, 'getByJalur']);


    //reset sandi

    Route::get('/users/{user}/edit-password', [AdminUserController::class, 'editPassword'])->name('admin.users.editPassword');
    Route::put('/users/{user}/update-password', [AdminUserController::class, 'updatePassword'])->name('admin.users.updatePassword');




    /////////////////////////////


    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.dashboard');
    Route::get('/pengguna/{id}', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::put('/pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.hapus');



    Route::get('/jalurdaftar', [JalurPendaftaranController::class, 'index'])->name('admin.jalurdaftar');
    Route::put('/jalurdaftar/create', [JalurPendaftaranController::class, 'store'])->name('jalurdaftar.create');
    Route::get('/jalurdaftar/edit', [JalurPendaftaranController::class, 'edit'])->name('jalurdaftar.edit');
    Route::post('/jalurdaftar/update', [JalurPendaftaranController::class, 'update'])->name('jalurdaftar.update');
    Route::get('/mapel', [MapelController::class, 'index'])->name('admin.mapel');
    Route::get('/mapel/create', [MapelController::class, 'create'])->name('mapel.create');
    Route::post('/mapel/save', [MapelController::class, 'store'])->name('mapel.simpan');
    Route::post('/mapel/update', [MapelController::class, 'update'])->name('mapel.update');
    Route::delete('/mapel/{id}', [MapelController::class, 'destroy'])->name('mapel.destroy');
    // untuk menampilkan jadwal pendaftaran
    Route::get('/jadwal', [JadwalPendaftaranController::class, 'index'])->name('admin.jadwal');
    Route::post('/jadwal/tambah', [PengaturanPpdbController::class, 'store'])->name('admin.tambahjadwal');
    // pengaturan ppdb
    Route::get('/pengaturan', [PengaturanPpdbController::class, 'index'])->name('admin.pengaturan');
    Route::post('/pengaturan/{id}/manifest', [PengaturanPpdbController::class, 'updateData'])->name('admin.updatedata');
    //update pengaturan
    Route::post('/jadwal-pendaftaran/{id}', [PengaturanPpdbController::class, 'update']);


    Route::get('/siswa/data', [PendaftaranController::class, 'data'])->name('siswa.data');
    Route::get('/pendaftar/diterima', [PendaftaranController::class, 'pendaftarDiterima'])->name('pendaftar.diterima');
    Route::get('/pendaftar/dataditerima', [PendaftaranController::class, 'dataDiterima'])->name('pendaftar.dataditerima');

    // data tables user

    Route::get('/admin/user', [PenggunaController::class, 'cariUser'])->name('admin.userdata');

    // export to excel

    Route::get('/export', [PendaftaranController::class, 'exportToExcel'])->name('exportExcel');

    //export semua jalur pendaftaran

    Route::get('/export-semua-jalur', [PendaftaranController::class, 'exportSemuaJalur'])->name('exportAll');
});
// pencarian dengan ajax+jquery



// Route::middleware(['auth', 'role:user'])->group(function () {
//     Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
// });


//
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin/dashboard', fn() => view('dashboard.admin.dashboard'))->name('admin.dashboard');
// });

// Route::middleware(['auth', 'role:operator'])->group(function () {
//     Route::get('/operator/dashboard', fn() => view('dashboard.operator.dashboard'))->name('operator.dashboard');
//     Route::get('/datasiswa', [PendaftaranController::class, 'datasiswa'])->name('admin.datasiswa');
//     Route::post('/datasiswa/{id}/batal', [PendaftaranController::class, 'batal'])->name('pendaftar.batal');
//     Route::get('/datasiswa/{id}/status', [PendaftaranController::class, 'status'])->name('siswa.status');
//     Route::put('/datasiswa/{id}/update', [PendaftaranController::class, 'update'])->name('status.update');
//     Route::get('/datasiswa/{id}', [PendaftaranController::class, 'editnilai'])->name('siswa.editnilai');
//     Route::put('/datasiswa/{id}', [PendaftaranController::class, 'updatenilai'])->name('siswa.updatenilai');
//     Route::post('/datasiswa/update-massal', [PendaftaranController::class, 'updateMassal'])->name('nilai.updateMassal');
//     Route::get('/admin/pendaftar/{id}/berkas', [PendaftaranController::class, 'showBerkas']);
//     Route::post('/datasiswa/{id}/approve', [PendaftaranController::class, 'approve'])->name('pendaftar.approve');
//     Route::get('/siswa/by-jalur/{jalur_id}', [PendaftaranController::class, 'getByJalur']);


//     Route::get('/siswa/data', [PendaftaranController::class, 'data'])->name('siswa.data');
//     Route::get('/pendaftar/diterima', [PendaftaranController::class, 'pendaftarDiterima'])->name('pendaftar.diterima');
//     Route::get('/pendaftar/dataditerima', [PendaftaranController::class, 'dataDiterima'])->name('pendaftar.dataditerima');
// });

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/user/dashboard', fn() => view('dashboard.user.dashboard'))->name('user.dashboard');
    Route::get('/pendaftar/create', [PendaftaranController::class, 'create'])->name('pendaftar.create');
    Route::post('/pendaftar', [PendaftaranController::class, 'store'])->name('pendaftar.store');
    Route::get('/pendaftar/{id}/cetak', [PendaftaranController::class, 'cetak'])->name('pendaftar.cetak');
    Route::get('/formulir', [PendaftaranController::class, 'index'])->name('formulir');
    Route::put('/formulir/{id}', [PendaftaranController::class, 'updatePendaftar'])->name('formulir.update');
    Route::get('/nilai', [NilaiPendaftarController::class, 'index'])->name('nilai');
    Route::get('/nilai/create', [NilaiPendaftarController::class, 'create'])->name('nilai.create');
    Route::post('/nilai', [NilaiPendaftarController::class, 'store'])->name('nilai.store');
    Route::get('/nilai/{id}/edit', [NilaiPendaftarController::class, 'edit'])->name('nilai.edit');
    Route::put('/nilai/{id}', [NilaiPendaftarController::class, 'update'])->name('nilai.update');
    Route::delete('/nilai/{id}', [NilaiPendaftarController::class, 'destroy'])->name('nilai.destroy');
    Route::get('/berkas', [BerkasPendaftarController::class, 'index'])->name('user.berkas');
    Route::post('/upload', [BerkasPendaftarController::class, 'upload'])->name('upload');
    Route::delete('/berkas/{id}', [BerkasPendaftarController::class, 'destroy'])->name('berkas.hapus');



    //get mapel
    Route::get('/user/getmapel', [NilaiPendaftarController::class, 'getMapel']);
    Route::post('/user/setmapel', [NilaiPendaftarController::class, 'simpanData'])->name('nilai.simpan');
});

Route::middleware(['guest.redirect'])->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
});

//
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
