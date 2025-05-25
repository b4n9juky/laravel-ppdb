<x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <x-secondary-button type="button"><i data-feather="users" class="inline"></i></x-secondary-button>
            {{ __('Pendaftar Diterima / Validasi') }}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table id="pendaftartable" class="table table-bordered">
                   <thead class="bg-gray-200 text-xs uppercase text-gray-700">
                        <tr>
                            <th>Nomor</th>
                            <th>Nama</th>
                            <th>No Daftar</th>
                            <th>Jalur Pendaftaran</th>
                            <th>Total Nilai</th>

                            <th>Jenis Berkas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <script>
                $(function() {
                    $('#pendaftartable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '{{ route("pendaftar.dataditerima") }}',
                        columns: [{

                                data: null, // data null karena kita generate manual
                                name: 'nomor',
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
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
                                    let value = parseFloat(data) || 0;
                                    return `
                          <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                            <div class="h-4 bg-blue-500 text-white text-xs text-center leading-4" style="width: ${value}%; min-width: 2rem;">
                              ${value}
                            </div>
                          </div>`;
                                }
                            },

                            {
                                data: 'jenis_berkas',
                                name: 'jenis_berkas',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'status',
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            }
                        ],
                        drawCallback: function() {
                            feather.replace(); // render ulang feather icons
                        },
                        createdRow: function(row, data) {
                            if (parseFloat(data.total_nilai) >= 200) {
                                $(row).addClass('bg-green-100'); // Hijau muda
                            } else if (parseFloat(data.total_nilai) <= 100) {
                                $(row).addClass('bg-red-100'); // Merah muda
                            }
                        }

                    });

                });
            </script>

        </div>
    </div>
</x-app-layout>