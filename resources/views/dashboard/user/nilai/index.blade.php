<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nilai') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mx-2 my-2 px-2 py-2">

                        @if($nilai->isEmpty())

                        <div class="bg-red-800 text-white text-xl mt-5 mb-4 sm:rounded-lg px-2 py-2">
                            <x-danger-button><i data-feather="alert-triangle"></i>
                                Anda belum menyelesaikan Pendaftaran, Isi Nilai terlebih dahulu</x-danger-button>
                            <x-primary-button><i data-feather="edit"></i>
                                <a href="{{ route('nilai.create') }}">Input Nilai</a></x-primary-button>
                        </div>
                        @else
                        <div class="bg-green-600 text-white text-xl mt-5 mb-4 sm:rounded-lg px-2 py-2">
                            <p>Pendaftaran Berhasil, SIlahkan Ke Sekolah Untuk Mencetak Bukti Pendaftaran</p>
                        </div>

                        @endif
                    </div>
                    @if(session('success'))
                    <div class=" text-green-600 mb-4">{{ session('success') }}</div>
                    @endif

                    <div class="overflow-auto">
                        <table class="w-full text-sm text-left text-gray-700">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($nilai as $n)
                                <tr>
                                    <td class="border px-6 py-4 whitespace-nowrap text-black-600">{{ $n->mapel->nama_mapel }}</td>
                                    <td class="border px-6 py-4 whitespace-nowrap text-black-600">{{ $n->nilai }}</td>
                                    <td class="border px-6 py-4 whitespace-nowrap text-black-600">
                                        <a href="{{ route('nilai.edit', $n->id) }}" class="text-blue-500 mr-2"><button><i data-feather="edit"></i></button></a>
                                        <form action="{{ route('nilai.destroy', $n->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500"><i data-feather="trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4">Belum ada nilai.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
</x-app-layout>