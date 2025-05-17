<?php

namespace App\Http\Controllers\Admin;

use App\Models\JalurPendaftaran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JalurPendaftaranController extends Controller
{
    public function index()
    {
        $data = JalurPendaftaran::all();
        return view('dashboard.admin.jalurdaftar.index', compact('data'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_jalur' => 'required',
            'kuota' => 'required|string',
        ]);
        JalurPendaftaran::create([
            'nama_jalur' => $request->nama_jalur,
            'kuota' => $request->kuota,
        ]);

        return back()->with('success', 'Data berhasil disimpan.');
        // echo "ini adalah jalur pendaftaran";
    }
    public function edit()
    {
        $data = JalurPendaftaran::all();
        return view('dashboard.admin.jalurdaftar.edit', compact('data'));
    }
    public function update(Request $request)
    {
        $items = $request->input('items');

        foreach ($items as $id => $data) {
            JalurPendaftaran::where('id', $id)->update([
                'nama_jalur' => $data['nama_jalur'],
                'kuota' => $data['kuota'],
                'is_active' => $data['status'],
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }
}
