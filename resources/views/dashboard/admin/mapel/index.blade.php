<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-secondary-button type="button"><i data-feather="book" class="inline"></i></x-secondary-button>
            {{ __('Pengaturan Mata Pelajaran - Nilai Ujian') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
            @endif

            @if ($mapel->isEmpty())
            <p class="text-gray-600"> Belum ada Data Mapel</p>

            <x-info-button id="btnTambah">Tambah Data</x-info-button>
            @else

            <form action="{{ route('mapel.update') }}" method="POST">
                @csrf
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Nama Mapel</th>
                                <th class="px-4 py-2 border">Status</th>

                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mapel as $row)

                            <tr>
                                <input type="hidden" name="items[{{ $row->id }}][id]" value="{{ $row->id }}">
                                <td class="px-4 py-2 border text-center">{{$loop->iteration}}</td>
                                <td class="px-4 py-2 border text-center">
                                    <input type="text" name="items[{{ $row->id }}][nama_mapel]" value="{{ $row->nama_mapel }}">


                                </td>
                                <td class="px-4 py-2 border text-center">
                                    <input type="radio"
                                        name="items[{{ $row->id }}][status]"
                                        value="1"
                                        {{ old("items.$row->id.status", $row->is_active) == 1 ? 'checked' : '' }}> Aktif

                                    <input type="radio"
                                        name="items[{{ $row->id }}][status]"
                                        value="0"
                                        {{ old("items.$row->id.status", $row->is_active) == 0 ? 'checked' : '' }}> Non Aktif

                                </td>
                                <td class="px-4 py-2 border text-center">

                                    <x-secondary-button class="hapus-mapel bg-red" data-id="{{ $row->id }}">
                                        Hapus
                                    </x-secondary-button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="p-4 m-2 bg-gray-100">
                        <x-secondary-button type="submit">Simpan</x-secondary-button>
                        <x-info-button id="btnTambah">Tambah Data</x-info-button>
                    </div>
                </div>
                @endif
            </form>

        </div>
    </div>

    <!-- modal tambah data -->
    <div id="modalForm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-md p-6">
            <h2 class="text-xl font-semibold mb-4">Tambah Jadwal Pendaftaran</h2>
            <form id="formTambah">

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Nama Mapel</label>
                    <input type="text" name="nama_mapel" required class="w-full border px-3 py-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-medium">status</label>
                    <input type="radio" name="status" required value="1">Aktif
                    <input type="radio" name="status" required value="0">Tidak Aktif
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" id="btnTutup" class="px-4 py-2 border rounded text-gray-600">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.hapus-mapel', function() {
            if (!confirm("Yakin ingin menghapus mapel ini?")) return;

            var id = $(this).data('id');

            $.ajax({
                url: '/mapel/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(res) {
                    alert('Mapel berhasil dihapus.');
                    $('#row-' + id).remove(); // jika ingin hilangkan baris dari tabel
                },
                error: function() {
                    alert('Gagal menghapus mapel.');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Tampilkan modal
            $('#btnTambah').on('click', function() {
                $('#modalForm').removeClass('hidden');
            });

            // Sembunyikan modal
            $('#btnTutup').on('click', function() {
                $('#modalForm').addClass('hidden');
            });


            $('#formTambah').submit(function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: '{{ route("mapel.simpan") }}',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        // alert(res.success);

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            // text: res,
                            confirmButtonText: 'OK'
                        });



                        // $('#modalForm').addClass('hidden');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert("Gagal menyimpan: " + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>

</x-app-layout>