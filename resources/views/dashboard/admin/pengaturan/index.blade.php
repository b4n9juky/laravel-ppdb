<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Sekolah') }}
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">Pengaturan Sekolah / Madrasah</h2>

                    <form action="{{route('admin.updatedata', $settings->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf


                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Sekolah / Madrasah</label>
                            <input type="text" name="nama_sekolah"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{$settings->nama_sekolah}}" required>
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Alamat Sekolah / Madrasah</label>
                            <textarea name="alamat_sekolah" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{$settings->alamat_sekolah}}</textarea>

                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Nomor Kontak</label>
                            <input type="number" name="kontak"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{$settings->kontak}}" required>
                        </div>
                        <div class=" mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Kepala Sekolah / Madrasah</label>
                            <input type="text" name="nama_kepsek"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{$settings->nama_kepsek}}" required>
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">logo Sekolah / Madrasah</label>
                            <input type="file" name="logo_sekolah"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Isi logo sekolah format gambar">
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Kop Surat Sekolah / Madrasah</label>
                            <input type="file" name="kop_surat"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Isi kop surat">
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Tanda Tangan Kepsek / Kamad</label>
                            <input type="file" name="tanda_tangan"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Isi foto tanda tangan kepsek / kamad">
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Pendaftaran Dibuka</label>
                            <input type="text" name="dibuka" id="dibuka"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{$settings->dibuka}}">
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Pendaftaran ditutup</label>
                            <input type="text" name="ditutup" id="ditutup"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{$settings->ditutup}}">
                        </div>
                        <div class="mb-4">
                            <x-primary-button type="submit">Submit</x-primary-button> <x-info-button>Tambah Data</x-info-button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#dibuka", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "id"
            });
            flatpickr("#ditutup", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "id"
            });
        });
    </script>

</x-app-layout>