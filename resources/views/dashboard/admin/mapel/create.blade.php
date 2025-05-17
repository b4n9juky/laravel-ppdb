<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Mapel') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">



                    <form action="{{ route('mapel.simpan') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="nama mapel" class="block text-gray-700 font-semibold mb-2">Nama Mapel</label>
                            <input type="text" id="nisn" name="nama_mapel"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="isi nama mapel">
                        </div>
                        <div class="mb-4">
                            <label for="nama mapel" class="block text-gray-700 font-semibold mb-2">Status Mapel</label>
                            <input type="radio" id="nisn" name="status" value="1" placeholder="status">Aktif
                            <input type="radio" id="nisn" name="status" value="0" placeholder="status">Tidak Aktif
                        </div>

                </div>

                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Semua</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>