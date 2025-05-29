<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Carbon;
use Symfony\Component\VarDumper\VarDumper;

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
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === UserRole::ADMIN) {
            return redirect()->back()->with('error', 'User dengan role ADMIN tidak bisa dihapus.');
        }
        $user->delete();

        return redirect()->route('pengguna.dashboard')->with('success', 'User berhasil dihapus.');
    }

    public function cariUser(Request $request)
    {
        $search = $request->input('search.value');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $orderColumn = $request->input('order.0.column', 3); // default ke total_nilai
        $orderDir = $request->input('order.0.dir', 'desc');

        // Kolom urutan sesuai frontend
        $columns = ['id', 'name', 'email', 'role', 'created_at', 'updated_at'];
        $orderColumnName = $columns[$orderColumn] ?? 'role';

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
                'created_at' => Carbon::parse($item->created_at)->format('d-m-Y H:i:s'),
                'updated_at' => Carbon::parse($item->updated_at)->format('d-m-Y H:i:s'),
                'action' => view('dashboard.admin.pengguna.partials.actions', ['user' => $item])->render(),

            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => User::count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $result,
        ]);
    }
}
