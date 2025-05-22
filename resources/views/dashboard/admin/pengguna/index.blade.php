<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full table-auto" id="pengguna">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">E-mail</th>
                            <th class="px-4 py-2 border">Peran</th>
                            <th class="px-4 py-2 border">Waktu Daftar</th>
                            <th class="px-4 py-2 border">Waktu Pembaharuan</th>

                            <th class="px-4 py-2 border" colspan="2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>


            </div>

        </div>
    </div>

    <script>
        // Setup CSRF token untuk AJAX agar tidak 403


        $(function() {
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

                    }


                ],
                drawCallback: function() {
                    feather.replace(); // render ulang feather icons
                },

            });
        });
    </script>
</x-app-layout>