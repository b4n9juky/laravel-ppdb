<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (auth()->user()->pendaftaran)
                    <p class="mb-4">Status Pendaftaran Anda: <strong>{{ auth()->user()->pendaftaran->status }}</strong></p>

                    <a href="{{ route('pendaftar.cetak', auth()->user()->pendaftaran->id) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Cetak Bukti Pendaftaran
                    </a>
                </div>
            </div>
        </div>

    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="pendaftar_id" value="{{ (auth()->user()->pendaftaran->id) }}">

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
                @else
                <p class="mb-4">Anda belum melakukan pendaftaran.</p>

                <a href="{{ route('formulir') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Isi Formulir Pendaftaran
                </a>
                @endif
            </div>
        </div>

    </div>


</x-app-layout>