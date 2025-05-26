<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex justify-start">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight"> {{ __('Manajemen Pendaftar') }}</h2>
            </div>

            <div class="flex justify-end">
                <a href="{{route('exportAll')}}"><x-secondary-button><i data-feather="printer"></i> Excel</x-secondary-button></a>
            </div>
        </div>

    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table id="pendaftar-table" class="table table-bordered w-full ">
                    <thead class="bg-gray-200 text-xs uppercase text-gray-700">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No Daftar</th>
                            <th>Jalur</th>
                            <th>Total Nilai</th>
                            <th>Berkas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <script>
                // Setup CSRF token untuk AJAX agar tidak 403


                $('#pendaftar-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("siswa.data") }}',
                    columns: [{
                            data: null,
                            render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                        },
                        {
                            data: 'nama'
                        },
                        {
                            data: 'nomor_daftar'
                        },
                        {
                            data: 'jalur'
                        },
                        {
                            data: 'total_nilai',
                            render: function(data) {
                                const nilai = parseFloat(data) || 0;
                                return `
                    <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                        <div class="h-4 bg-blue-500 text-white text-xs text-center leading-4"
                             style="width: ${Math.min(nilai, 100)}%; min-width: 2rem;">
                             ${nilai}
                        </div>
                    </div>`;
                            }
                        },
                        {
                            data: 'jenis_berkas'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'action'
                        }
                    ],
                    createdRow: function(row, data) {
                        const nilai = parseFloat(data.total_nilai) || 0;
                        if (nilai >= 200) {
                            $(row).addClass('bg-green-100');
                        } else if (nilai <= 100) {
                            $(row).addClass('bg-red-100');
                        }
                    },
                    drawCallback: function() {
                        feather.replace(); // jika menggunakan ikon Feather
                    }
                });
            </script>
        </div>
    </div>
</x-app-layout>