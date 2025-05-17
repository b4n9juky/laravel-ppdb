<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\PengaturanPpdb;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
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


        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // return redirect()->intended(route('dashboard', absolute: false));
        $user = Auth::user();

        return match ($user->role) {
            UserRole::ADMIN => redirect()->route('admin.dashboard'),
            UserRole::OPERATOR => redirect()->route('operator.dashboard'),
            UserRole::USER => redirect()->route('user.dashboard'),
            default => abort(403, 'Unauthorized'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
