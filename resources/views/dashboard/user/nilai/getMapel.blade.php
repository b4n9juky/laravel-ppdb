<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Input Nilai</h2>
    </x-slot>
    <div class="py-12">
        @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>

        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('nilai.simpan') }}" method="POST">
                        @csrf



                        <table class="max-w-full table-auto">
                            @foreach($mapel as $m)
                            <tr>
                                <td>{{ $m->nama_mapel }}</td>
                                <td><input type="hidden" name="pendaftar_id" value="{{ $pendaftar->id }}"></td>
                                <td></td>
                                <td><input type="hidden" name="mapel_id[]" value="{{ $m->id }}"></td>
                                <td><input type="number" name="nilai[]" required></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2">
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                                </td>
                            </tr>
                        </table>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>