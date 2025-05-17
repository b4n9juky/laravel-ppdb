<?php

namespace App\Http\Controllers\Admin;

use App\Models\BerkasPendaftar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerkasController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.berkas.index');
    }
    public function store(Request $request)
    {
        $request->validate([]);
    }
}
