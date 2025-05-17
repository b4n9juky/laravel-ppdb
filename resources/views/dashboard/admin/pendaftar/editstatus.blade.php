<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ubah Status Pendaftaran') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h4>Berkas Foto:</h4>
                    @if($berkas->berkas->count())
                    <ul>
                        @foreach($berkas->berkas as $foto)
                        <li>
                            <strong>{{ $foto->jenis_berkas }}:</strong><br>
                            <img src="{{ asset('storage/'. $foto->file_path) }}" width="150" alt="Foto {{ $foto->jenis_berkas }}">
                            <a href="{{ asset('storage/' . $foto->file_path) }}" target="_blank"
                                class="text-blue-500 underline">Lihat</a>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">Data berhasil disimpan.</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <title>Close</title>
                                <path d="M14.348 5.652a1 1 0 0 0-1.414 0L10 8.586 
         7.066 5.652A1 1 0 0 0 5.652 7.066L8.586 10l-2.934 2.934a1 1 0 1 0 1.414 1.414L10 
         11.414l2.934 2.934a1 1 0 0 0 1.414-1.414L11.414 10l2.934-2.934a1 1 0 0 0 0-1.414z" />
                            </svg>
                        </span>
                    </div>

                    @endif




                    <form action="{{ route('status.update', $status->id) }}" method="POST">
                        @csrf @method('PUT')
                        <label for="nama" class="block">Nama</label>
                        <input type="text" value=" {{$status->nama_lengkap}}" disabled>
                        <label for="Asal Sekolah" class="block">Sekolah Asal</label>
                        <input type="text" value="{{$status->sekolah_asal}}" disabled>
                        <label for="alamat" class="block">Alamat</label>
                        <textarea class="block" disabled>{{$status->alamat}}</textarea>

                        <div class="mb-4">
                            <label class="block">Status Pendaftaran</label>
                            <select name="status" required class="w-full border px-3 py-2">
                                <option value="Menunggu">Menunggu</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Ditolak">Ditolak</option>
                                <option value="Cadangan">Cadangan</option>

                            </select>
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                    </form>
                </div>
</x-app-layout>