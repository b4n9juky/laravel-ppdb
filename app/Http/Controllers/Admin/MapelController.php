<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mapel;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MapelController extends Controller
{
    public function index()
    {
        $mapel = Mapel::all();
        return view('dashboard.admin.mapel.index', compact('mapel'));
    }
    public function create()
    {
        return view('dashboard.admin.mapel.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required',
            'status' => 'required',
        ]);
        Mapel::create([
            'nama_mapel' => $request->nama_mapel,
            'is_active' => $request->status,
        ]);

        return back()->with('success', 'Data berhasil disimpan.');
        // echo "ini adalah jalur pendaftaran";
    }
    public function edit()
    {
        $data = Mapel::all();
        return view('dashboard.admin.jalurdaftar.edit', compact('data'));
    }
    public function update(Request $request)
    {
        $items = $request->input('items');

        foreach ($items as $id => $data) {
            Mapel::where('id', $id)->update([
                'nama_mapel' => $data['nama_mapel'],
                'is_active' => $data['status'],
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }
    // public function destroy($id)
    // {
    //     $mapel = Mapel::findOrFail($id);
    //     $mapel->delete();

    //     return back()->with('success', 'Data berhasil dihapus.');
    // }
    public function destroy($id)
    {
        $sisaData = Mapel::count();
        if ($sisaData == 1) {
            return back()->with('error', 'Data tidak dapat dihapus karena tidak ada data yang tersedia');
        } else {
            Mapel::destroy($id);
            return response()->json(['message' => 'Berhasil dihapus']);
        }
    }
}
