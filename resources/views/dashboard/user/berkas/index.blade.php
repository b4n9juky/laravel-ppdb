<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Berkas') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <!-- // berkas yang sudah di upload -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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


                @if ($berkas->isEmpty())


                <script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian!',
                        text: 'Anda belum mengupload berkas apa pun.',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true,
                        toast: false,
                        position: 'center'
                    });
                </script>


                @else


                <div class="bg-white overflow-x-auto overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <table class="min-w-full border border-gray-300 divide-y divide-gray-200 text-sm text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Jenis Berkas</th>
                                <th class="px-4 py-2 border">Lihat File</th>
                                <th class="px-4 py-2 border">Tanggal Upload</th>
                                <th class="px-4 py-2 border">Tanggal diperbaharui</th>
                                <th class="px-4 py-2 border" colspan="2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">


                            @foreach ($berkas as $docx)
                            <tr>
                                <td class="px-4 py-2 border text-center">{{$loop->iteration}}</td>
                                <td class="px-4 py-2 border text-center">{{$docx->jenis_berkas}}</td>
                                <td class="px-4 py-2 border text-left">




                                    @php
                                    $ext = pathinfo($docx->file_path, PATHINFO_EXTENSION);
                                    @endphp@if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                    <a href="{{ asset('storage/' . $docx->file_path) }}" data-lightbox="galeri" data-title="{{ $docx->caption }}">
                                        <img src="{{ asset('storage/' . $docx->file_path) }}" alt="Foto" class="rounded-lg shadow-md hover:scale-105 transition duration-300" width="100" height="100">
                                    </a>
                                    @elseif(strtolower($ext) === 'pdf')

                                    <iframe src="{{ asset('storage/' . $docx->file_path) }}" width="100px" height="50px">
                                        File PDF tidak bisa ditampilkan.
                                    </iframe>
                                    <p><a href="{{ asset('storage/' . $docx->file_path) }}" target="_blank">
                                            <i data-feather="eye" class="w-4 h-4 mr-2 mt-5 mb-5 inline"></i>
                                            <i data-feather="download" class="w-4 h-4 mr-2 mt-5 mb-5 inline"></i>


                                        </a></p>
                                    @else
                                    <p><a href="{{ asset('storage/' . docx->file_path) }}" target="_blank">Download File</a></p>
                                    @endif
                                </td>

                                <td class="px-4 py-2 border text-center">{{$docx->created_at}}</td>
                                <td class="px-4 py-2 border text-center">{{$docx->updated_at}}</td>
                                <form action="{{route('berkas.hapus',$docx->id)}}" method="post" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf @method('DELETE')
                                    <td class="px-4 py-2 border text-center"><x-danger-button>
                                            <i data-feather="trash-2"></i>
                                        </x-danger-button></td>
                                </form>
                                @endforeach

                        </tbody>
                    </table>
                </div>
                @endif

            </div>
        </div>

        <!-- // form upload berkas -->

        <div class=" max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pendaftar_id" value="{{ (auth()->user()->pendaftaran->id) }}">

                        <div class="mb-4">
                            <label for="jenis_berkas" class="block font-medium text-sm text-gray-700">Jenis Berkas</label>
                            <select name="jenis_berkas" class="mt-1 block w-full" required>
                                <option value="">Pilih Jenis</option>
                                <option value="skl">SKL</option>
                                <option value="foto">Pas Foto</option>
                                <option value="kk">Kartu Keluarga</option>
                                <option value="akta_lahir">Akta Lahir</option>
                                <option value="kip">Kartu KIP ( Jika ada )</option>
                                <option value="piagam">Piagam / Sertifikat (Jika ada )</option>
                                <option value="rapor">Rapor</option>


                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="file" class="block font-medium text-sm text-gray-700">Upload File</label>
                            <input type="file" name="file" accept=".pdf,.jpeg,image/jpeg" required class="mt-1 block w-full">
                        </div>

                        <x-primary-button type="submit" class="bg-blue-800">Upload Berkas</x-primary-button>
                        <a href=" {{route('nilai')}}"><x-secondary-button>Selanjutnya</x-secondary-button></a>
                    </form>

                </div>
            </div>

        </div>
    </div>


</x-app-layout>