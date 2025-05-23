<x-app-layout>
    <x-slot name="header">

        @foreach($jalur as $j)
        <x-success-button class="filter-jalur" data-jalur-id="{{$j->id}}">{{$j->nama_jalur}}</x-success-button>

        @endforeach
        <a href="{{route('siswa.diterima')}}"><x-info-button>Rekap</x-info-button></a>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>

            @endif
            @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-gray-800 rounded">
                {{ session('error') }}
            </div>

            @endif

            @if ($siswa->isEmpty())
            <p class="text-gray-600"> Belum ada Calon Siswa.</p>
            @else


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" id="tabel-siswa">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Jalur Daftar</th>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">Asal Sekolah</th>
                            <th class="px-4 py-2 border">Status Daftar</th>
                            <th class="px-4 py-2 border">Total Nilai</th>

                            <th class="px-4 py-2 border">Waktu Pendaftaran</th>

                            <th class="px-4 py-2 border">Berkas</th>
                            <th class="px-4 py-2 border">Atur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $row)

                        <tr>
                            <td class="px-4 py-2 border text-left text-xs uppercase">{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</td>
                            <td class="px-4 py-2 border text-left text-xs uppercase">{{ $row->jalur->nama_jalur ?? '-'  }}</td>
                            <td class="px-4 py-2 border text-left text-xs uppercase">{{ $row->nama_lengkap }}</td>
                            <td class="px-4 py-2 border text-left text-xs uppercase">{{ $row->sekolah_asal }}</td>
                            <td class="px-4 py-2 border text-center"><a href="{{ route('siswa.status', $row->id) }}" class="text-blue-500 mr-2">
                                    @if($row->status =='Cadangan')
                                    <x-warning-button>{{ $row->status }}</x-warning-button> </a>
                                @elseif($row->status =='Menunggu')
                                <x-info-button>{{ $row->status }}</x-info-button></a>

                                @else
                                <x-success-button>{{ $row->status }}</x-success-button></a>
                                @endif
                            </td>
                            <td class="px-4 py-2 border text-center"><a href="{{route('siswa.editnilai',$row->id)}}">
                                    <x-primary-button>{{$row->total_nilai ?? 0}}</x-primary-button>
                                </a></td>
                            <td class="px-4 py-2 border text-left text-xs uppercase">{{ $row->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 border text-center">

                                @foreach($row->berkas as $file)
                                <ul class="list-disc list-inside text-left text-xs uppercase">

                                    <li>
                                        <a href="#" class="lihat-berkas text-blue-600" data-id="{{ $row->id }}">
                                            {{ $file->jenis_berkas }}
                                        </a>
                                    </li>
                                </ul>
                                @endforeach

                            </td>
                            <td class="px-4 py-2 border text-center">

                                <form action="{{ route('pendaftar.approve', $row->id) }}" method="POST">
                                    @csrf

                                    <x-primary-button type="submit">Proses</x-primary-button>
                                </form>
                                <form action="{{ route('pendaftar.batal', $row->id) }}" method="POST">
                                    @csrf

                                    <x-danger-button type="submit">Batal</x-danger-button>
                                </form>



                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            @endif

            <div class="mt-6">
                {{ $siswa->links() }}

            </div>
        </div>
    </div>
    <!-- Modal untuk menampilkan berkas -->
    <!-- Modal -->
    <div id="berkasModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
        <div id="berkasModalContainer" class="bg-white w-11/12 md:w-2/3 lg:w-1/3 p-6 rounded shadow relative">
            <div id="berkasModalContent"></div>
            <button id="closeModalBtn" class="absolute top-2 right-2 text-gray-700 hover:text-red-600 text-xl">&times;</button>
        </div>
    </div>

    <!-- jquery untuk menampilkan berkas -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Tampilkan modal saat klik berkas
            $(document).on('click', '.lihat-berkas', function(e) {
                e.preventDefault();
                const pendaftarId = $(this).data('id');

                $.ajax({
                    url: '/admin/pendaftar/' + pendaftarId + '/berkas',
                    method: 'GET',
                    success: function(response) {
                        $('#berkasModalContent').html(response);
                        $('#berkasModal').removeClass('hidden').addClass('flex');
                    },
                    error: function() {
                        alert('Gagal memuat berkas.');
                    }
                });
            });

            // Tutup modal saat klik tombol close
            $('#closeModalBtn').on('click', function() {
                $('#berkasModal').removeClass('flex').addClass('hidden');
            });

            // Tutup modal saat klik di luar container modal
            $('#berkasModal').on('click', function(e) {
                if (!$(e.target).closest('#berkasModalContainer').length) {
                    $('#berkasModal').removeClass('flex').addClass('hidden');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.filter-jalur').click(function() {
                var jalurId = $(this).data('jalur-id');
                console.log(jalurId);

                $.ajax({
                    url: '/siswa/by-jalur/' + jalurId,
                    type: 'GET',
                    success: function(response) {
                        $('#tabel-siswa').html(response);
                    },
                    error: function(xhr) {
                        $('#tabel-siswa').html('<p>Gagal mengambil data siswa.</p>');
                    }
                });
            });
        });
    </script>



</x-app-layout>