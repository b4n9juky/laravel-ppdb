<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Formulir') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">


                    @if(session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: '{{ session("success") }}',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            toast: false,
                            position: 'center'
                        });
                    </script>
                    @endif




                    <form action="{{route('formulir.update',$data->id)}}" method="POST">
                        @csrf @method('PUT')

                        <h2 class="text-2xl font-bold mb-4 text-gray-800">Edit Formulir Pendaftaran</h2>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">NISN</label>
                            <input type="text" id="nisn" name="nisn"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{$data->nisn}}">
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Nomor Pendaftaran</label>
                            <input type="text" id="nama" name="nomor_pendaftaran"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{$data->nomor_pendaftaran}}" readonly>
                        </div>

                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama_lengkap"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{$data->nama_lengkap}}">
                        </div>



                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                                <option value="laki-laki" {{ $data->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="perempuan" {{ $data->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Tempat Lahir</label>
                            <input type="text" id="nama" name="tempat_lahir"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{$data->tempat_lahir}}">
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Tanggal Lahir</label>


                            <input type="text" id="tanggal_lahir" name="tanggal_lahir" autocomplete="off"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('tanggal_lahir', $data->tanggal_lahir) }}">
                        </div>

                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Sekolah Asal</label>
                            <input type="text" id="nama" name="sekolah_asal"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{$data->sekolah_asal}}">
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Alamat Lengkap</label>
                            <textarea name="alamat"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{$data->alamat}}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">No HP</label>
                            <input type="number" id="nama" name="no_hp"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{$data->no_hp}}">
                        </div>
                        <!-- <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Jalur Pendaftaran</label>
                            <select name="jalur_pendaftaran" id=""
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="reguler">Reguler</option>
                                <option value="afirmasi">Afirmasi</option>
                                <option value="prestasi">Prestasi</option>
                                <option value="luar kota">Luar Kota</option>
                                <option value="anakguru">Anak Guru</option>
                                <option value="tahfidz">Tahfidz</option>
                            </select>
                        </div> -->

                        <div class="mb-4">
                            <label for="jalurdaftar_id" class="block font-medium text-sm text-gray-700">Jalur Pendaftaran</label>
                            <select name="jalurdaftar" id="jalurdaftar_id" class="form-select rounded mt-1 block w-full">
                                @foreach($jalur as $item)
                                <option value="{{ $item->id }}"
                                    {{ $data->jalurdaftar_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_jalur }}
                                </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 font-semibold mb-2">Status</label>
                            <input type="text" id="nama" name="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{$data->status}}" readonly>
                        </div>
                        <x-primary-button type="submit">Update</x-primary-button>
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