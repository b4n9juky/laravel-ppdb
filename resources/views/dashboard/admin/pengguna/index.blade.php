<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
            @endif

            @if ($siswa->isEmpty())
            <p class="text-gray-600"> Belum ada Pengguna</p>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">E-mail</th>
                            <th class="px-4 py-2 border">Peran</th>
                            <th class="px-4 py-2 border">Waktu Daftar</th>
                            <th class="px-4 py-2 border">Waktu Pembaharuan</th>

                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $row)

                        <tr>
                            <td class="px-4 py-2 border text-center">{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage()}}</td>
                            <td class="px-4 py-2 border text-center">{{ $row->name }}</td>
                            <td class="px-4 py-2 border text-center">{{ $row->email }}</td>

                            <td class="px-4 py-2 border text-center"><a href="{{ route('pengguna.edit', $row->id) }}" class="text-blue-500 mr-2">{{ $row->role }}</a></td>
                            <td class="px-4 py-2 border text-center">{{ $row->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 border text-center">{{ $row->updated_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 border text-center"><a href="{{route('pengguna.edit',$row->id)}}"><x-secondary-button>Ubah</x-secondary-button></a></td>
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
</x-app-layout>