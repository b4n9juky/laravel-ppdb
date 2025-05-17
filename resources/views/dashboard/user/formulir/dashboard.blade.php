@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
    <h1 class="text-xl font-semibold mb-4">Dashboard Pendaftar</h1>

    @include('pendaftar.partials.navigasi_proses', ['step' => $currentStep])

    <div class="mt-6 space-y-4">
        {{-- Status Formulir --}}
        <div class="flex justify-between items-center">
            <div>✅ Formulir</div>
            @if ($pendaftar->formulirTerisi())
            <span class="text-green-600">Sudah diisi</span>
            @else
            <a href="{{ route('pendaftar.formulir') }}" class="text-blue-600 underline">Isi Formulir</a>
            @endif
        </div>

        {{-- Status Nilai --}}
        <div class="flex justify-between items-center">
            <div>📄 Nilai</div>
            @if ($pendaftar->nilai()->exists())
            <span class="text-green-600">Sudah diisi</span>
            @else
            <a href="{{ route('pendaftar.nilai') }}" class="text-blue-600 underline">Isi Nilai</a>
            @endif
        </div>

        {{-- Status Berkas --}}
        <div class="flex justify-between items-center">
            <div>📎 Berkas</div>
            @if ($pendaftar->berkas()->exists())
            <span class="text-green-600">Sudah diupload</span>
            @else
            <a href="{{ route('pendaftar.berkas') }}" class="text-blue-600 underline">Upload Berkas</a>
            @endif
        </div>
    </div>

    @if ($pendaftar->isLengkap())
    <div class="mt-6 text-center">
        <a href="{{ route('pendaftar.cetak') }}" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            🖨️ Cetak Bukti Pendaftaran
        </a>
    </div>
    @else
    <div class="mt-6 text-center text-sm text-gray-600">
        Lengkapi semua proses untuk mencetak bukti pendaftaran.
    </div>
    @endif
</div>
@endsection