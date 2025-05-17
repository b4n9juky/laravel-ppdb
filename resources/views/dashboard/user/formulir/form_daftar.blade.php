<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulir') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="/pendaftar" method="POST">
                        @csrf

                        <h2 class="text-2xl font-bold mb-4 text-gray-800">Formulir Pendaftaran</h2>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">NISN</label>
                            <input type="text" id="nisn" name="nisn"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Isi NISN yang benar">
                        </div>

                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama_lengkap"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan nama anda">
                        </div>



                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Tempat Lahir</label>
                            <input type="text" id="nama" name="tempat_lahir"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan Tempat Lahir">
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Tanggal Lahir</label>
                            <input type="text" id="tanggal_lahir" name="tanggal_lahir" autocomplete="off"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan Tanggal lahir">
                        </div>

                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Sekolah Asal</label>
                            <input type="text" id="nama" name="sekolah_asal"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan nama anda">
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Alamat Lengkap</label>
                            <textarea name="alamat"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan Alamat Anda"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">No HP</label>
                            <input type="text" id="nama" name="no_hp"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan nomer hp">
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Jalur Pendaftaran</label>
                            <select name="jalurdaftar" id=""
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach($jalur as $row)
                                <option value="{{ $row->id}}">{{$row->nama_jalur}}</option>
                                @endforeach
                            </select>

                        </div>
                        <x-primary-button type="submit">Daftar</x-primary-button>
                    </form>
                </div>
            </div>

            </button>

            <script>
                $(function() {
                    $("#tanggal_lahir").datepicker({
                        dateFormat: "yy-mm-dd",
                        changeMonth: true,
                        changeYear: true,
                        yearRange: "1950:2025"
                    });
                });
            </script>
</x-app-layout>