<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminUserController extends Controller
{
    public function editPassword(User $user)
    {
        return view('dashboard.admin.pengguna.resetsandi', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('pengguna.dashboard')->with('success', 'Password berhasil diperbarui.');
    }
}
