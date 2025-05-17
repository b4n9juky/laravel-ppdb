
@if(session('success'))
    <div class="text-green-500 mb-2">{{ session('success') }}</div>
@endif
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulir') }}
        </h2>
    </x-slot>
    <div class="py-12">
<form action="{{ route('pendaftar.upload_berkas') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="pendaftar_id" value="{{ $pendaftar->id }}">

    <div class="mb-4">
        <label for="jenis_berkas" class="block font-medium text-sm text-gray-700">Jenis Berkas</label>
        <select name="jenis_berkas" class="mt-1 block w-full" required>
            <option value="">Pilih Jenis</option>
            <option value="kk">Kartu Keluarga</option>
            <option value="akta">Akta Lahir</option>
            <option value="foto">Pas Foto</option>
        </select>
    </div>

    <div class="mb-4">
        <label for="file" class="block font-medium text-sm text-gray-700">Upload File</label>
        <input type="file" name="file" required class="mt-1 block w-full">
    </div>

    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">
        Upload Berkas
    </button>
</form>
    </div>
</x-app-layout>
