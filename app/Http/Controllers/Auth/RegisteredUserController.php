<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\PengaturanPpdb;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $pengaturan = PengaturanPpdb::select('id', 'dibuka', 'ditutup')->first();

        if (!$pengaturan) {
            return view('beranda')->with('error', 'Pengaturan belum tersedia');
        }

        $now = Carbon::now();

        if ($now->lt($pengaturan->dibuka)) {
            // return view('beranda')->with('error', 'Pendaftaran belum dibuka');
            return view('beranda')->with('warning', 'Pendaftaran Belum dibuka.');
        }

        if ($now->gt($pengaturan->ditutup)) {
            // return view('beranda')->with('error', 'Pendaftaran telah ditutup');
            return view('beranda')->with('warning', 'Pendaftaran telah ditutup ..');
        }
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => UserRole::USER,

        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('user.dashboard', absolute: false));
    }
}
