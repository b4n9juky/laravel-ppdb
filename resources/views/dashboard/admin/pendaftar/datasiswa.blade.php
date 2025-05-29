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
                <table id="pendaftar-table" class="table table-bordered w-full">
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
            <style>
                .progress-container {
                    background-color: #e5e7eb;
                    /* gray-200 */
                    border-radius: 9999px;
                    height: 1rem;
                    overflow: hidden;
                }

                .progress-bar {
                    background-color: #3b82f6;
                    /* blue-500 */
                    color: white;
                    height: 100%;
                    text-align: center;
                    line-height: 1rem;
                    font-size: 0.75rem;
                    border-radius: 9999px;
                    min-width: 2rem;
                }
            </style>

            <script>
                // Setup CSRF token untuk AJAX agar tidak 403


                $('#pendaftar-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route("siswa.data") }}',
                    order: [
                        [4, 'desc']
                    ],

                    columns: [{
                            data: 'id',
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
                                const persen = Math.min(nilai, 100);

                                // Tentukan warna berdasarkan nilai
                                let warna = 'bg-red-500';
                                if (nilai > 100 && nilai < 200) {
                                    warna = 'bg-yellow-500';
                                } else if (nilai >= 200) {
                                    warna = 'bg-green-500';
                                }

                                return `
            <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                <div class="h-4 ${warna} text-white text-xs text-center leading-4"
                     style="width: ${persen}%; min-width: 2rem;">
                    ${nilai}
                </div>
            </div> `;

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