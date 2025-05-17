<!-- Pengaturan buka tutup pendaftaran -->
<!-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-4 text-gray-800">Jadwal Pendaftaran PPDB Tahun {{date("Y")}}</h2>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" id="tabel-siswa">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border">No</th>
                                    <th class="px-4 py-2 border">Jalur Daftar</th>
                                    <th class="px-4 py-2 border">Waktu Buka </th>
                                    <th class="px-4 py-2 border">Waktu Tutup</th>
                                    <th class="px-4 py-2 border">Atur</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($jadwals as $j)

                                <tr>
                                    <td class="px-4 py-2 border text-left">{{$loop->iteration}}</td>
                                    <td class="px-4 py-2 border text-left">{{$j->jalur->nama_jalur}}</td>
                                    <td class="px-4 py-2 border text-left">{{$j->dibuka_pada}}</td>
                                    <td class="px-4 py-2 border text-left">{{$j->ditutup_pada}}</td>
                                    <td class="px-4 py-2 border text-left">

                                        <x-warning-button class="btn-edit"
                                            data-id="{{ $j->id }}"
                                            data-nama-jalur="{{ $j->jalur->nama_jalur }}"
                                            data-jalur-id="{{ $j->jalur->id }}"
                                            data-dibuka="{{ $j->dibuka_pada }}"
                                            data-ditutup="{{ $j->ditutup_pada }}">
                                            Edit
                                        </x-warning-button>




                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="mb-4 mt-5">
                        <x-info-button id="btnTambah">Tambah Data</x-info-button>


                    </div>
                </div>

            </div>
            <!-- Modal untuk menampilkan jadwal pendaftaran -->
<!-- Modal -->
<!-- Modal Tambah Jadwal -->
<div id="modalForm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <h2 class="text-xl font-semibold mb-4">Tambah Jadwal Pendaftaran</h2>
        <form id="formTambah">
            <div class="mb-4">
                <label class="block mb-1 font-medium">Jalur Pendaftaran</label>
                <select name="jalur_id" required class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">-- Pilih Jalur --</option>
                    @foreach($jalurs as $jalur)
                    <option value="{{ $jalur->id }}">{{ $jalur->nama_jalur }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" required class="w-full border px-3 py-2 rounded">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" required class="w-full border px-3 py-2 rounded">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" id="btnTutup" class="px-4 py-2 border rounded text-gray-600">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>


<!-- modal edit -->

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg w-full max-w-md p-6">
        <h2 class="text-xl font-semibold mb-4">Tambah Jadwal Pendaftaran</h2>
        <form id="editForm">
            <div class="mb-4">
                <input type="hidden" name="jadwal_id" id="jadwalId">

                <label class="block mb-1 font-medium">Jalur Pendaftaran</label>
                <select name="jalur_id" id="edit_jalur_id" required class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">-- Pilih Jalur --</option>
                    @foreach($jalurs as $jalur)
                    <option value="{{ $jalur->id }}">{{ $jalur->nama_jalur }}</option>
                    @endforeach
                </select>

            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Tanggal Mulai</label>
                <input type="text" name="tanggal_mulai" id="dibuka_pada" required class="tanggal w-full border px-3 py-2 rounded">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-medium">Tanggal Selesai</label>
                <input type="text" name="tanggal_selesai" id="ditutup_pada" required class="w-full border px-3 py-2 rounded">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" id="close" class="px-4 py-2 border rounded text-gray-600">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
<!-- akhir modal edit -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                url: '{{ route("admin.tambahjadwal") }}',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    alert(res.success);
                    $('#modalForm').addClass('hidden');
                    location.reload();
                },
                error: function(xhr) {
                    alert("Gagal menyimpan: " + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
<!-- Js Edit -->
<script>
    $(document).ready(function() {
        $('.btn-edit').on('click', function() {
            $('#jadwalId').val($(this).data('id'));
            $('#edit_jalur_id').val($(this).data('jalur-id'));
            $('#dibuka_pada').val($(this).data('dibuka'));
            $('#ditutup_pada').val($(this).data('ditutup'));
            $('#editModal').removeClass('hidden');
        });

        $('#close').on('click', function() {
            $('#editModal').addClass('hidden');
        });

        $('#editForm').on('submit', function(e) {
            e.preventDefault();

            const id = $('#jadwalId').val();
            const data = $(this).serialize();

            $.ajax({
                url: '/jadwal-pendaftaran/' + id,
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(res) {
                    alert(res.success || "Data berhasil diperbarui.");
                    location.reload();
                },
                error: function(err) {
                    alert('Gagal menyimpan perubahan');
                }
            });
        });
    });
</script>
</div>
</div> -->




<!-- Pengaturan Identitas Madrasah -->