<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Models\PengaturanPpdb;

class CheckAccessTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        // Ambil pengaturan pertama (atau sesuaikan dengan ID tertentu)
        $setting = PengaturanPpdb::first();

        if (!$setting || !$setting->dibuka || !$setting->ditutup) {
            // Jika tidak ada pengaturan valid
            return abort(503, 'Waktu akses belum ditentukan.');
        }

        $now = Carbon::now();
        $waktuBuka = Carbon::parse($setting->dibuka);
        $waktuTutup = Carbon::parse($setting->ditutup);

        if ($now->lt($waktuBuka)) {
            return response()->view('errors.not_available', [
                'message' => 'Halaman belum tersedia. Akses dibuka pada ' . $waktuBuka->format('d M Y H:i')
            ]);
        }

        if ($now->gt($waktuTutup)) {
            return response()->view('errors.not_available', [
                'message' => 'Masa akses halaman ini telah berakhir pada ' . $waktuTutup->format('d M Y H:i')
            ]);
        }

        return $next($request);
    }
}
