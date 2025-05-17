<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;


class PenggunaController extends Controller
{
    //menampilkan semua user yang terdaftar

    public function index()
    {

        $siswa = User::where('role', 'user')->paginate(10);
        // $pengguna = $data->paginate(2);

        return view('dashboard.admin.pengguna.index', compact('siswa'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.admin.pengguna.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([

            'role' => 'required|in:admin,user,operator',
        ]);
        $user = User::findOrFail($id);


        $user->update([

            'role' => $request->role,
        ]);

        return redirect()->route('pengguna.dashboard')->with('success', 'Data berhasil diperbarui.');
    }
}
