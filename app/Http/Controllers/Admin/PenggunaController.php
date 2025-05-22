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

        // $siswa = User::where('role', 'user')->paginate(10);
        // $pengguna = $data->paginate(2);


        return view('dashboard.admin.pengguna.index');
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
    public function destroy($id) {}
    public function cariUser(Request $request)
    {
        $search = $request->input('search.value');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $orderColumn = $request->input('order.0.column', 3); // default ke total_nilai
        $orderDir = $request->input('order.0.dir', 'desc');

        // Kolom urutan sesuai frontend
        $columns = ['id', 'name', 'email', 'role', 'created_at', 'updated_at'];
        $orderColumnName = $columns[$orderColumn] ?? 'peran';

        // Query utama
        $query = User::query();

        // Pencarian global
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Hitung jumlah setelah filter
        $recordsFiltered = $query->count();

        // // Sorting (hanya kolom model langsung, bukan relasi)
        // if ($orderColumnName !== 'name') {
        $query->orderBy($orderColumnName, $orderDir);
        // }

        // Ambil data
        $data = $query->skip($start)->take($length)->get();

        // Format untuk DataTables
        $result = $data->map(function ($item) {
            return [
                'name' => $item->name,
                'email' => $item->email,
                'role' => $item->role,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'action' => '
        <div class="flex space-x-2">
            <a href="' . route('admin.users.editPassword', $item->id) . '" class="inline-flex items-center px-2 py-1 text-white bg-blue-600 hover:bg-red-700 rounded text-sm">
                <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reset</a>
               
                <form action="' . route('pendaftar.batal', $item->id) . '" method="POST" onsubmit="return confirm(\'Yakin ingin membatalkan?\')">
                ' . csrf_field() . '<button type="submit" class="inline-flex items-center px-2 py-1 text-white bg-red-600 hover:bg-red-700 rounded text-sm">
                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>Hapus</button>
            </form>
                
        </div>',
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => User::all()->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $result,
        ]);
    }
}
