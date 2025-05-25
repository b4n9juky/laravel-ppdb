<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full table-auto" id="pengguna">
                     <thead class="bg-gray-200 text-xs uppercase text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border">Nomor</th>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">E-mail</th>
                            <th class="px-4 py-2 border">Peran</th>
                            <th class="px-4 py-2 border">Waktu Daftar</th>
                            <th class="px-4 py-2 border">Waktu Pembaharuan</th>

                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#pengguna').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.userdata") }}',
                columns: [{
                        data: null,
                        name: 'nomor',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function() {
                    feather.replace();
                }
            });
        });
    </script>


</x-app-layout>