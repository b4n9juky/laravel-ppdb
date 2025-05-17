<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Input Nilai</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('nilai.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pendaftar_id" value="{{ $pendaftar->id }}">

                        <div class="mb-4">
                            <label class="block">Mata Pelajaran</label>
                            <select name="mapel_id" class="text white-800" required>
                                <option value="">Pilih Mapel</option>
                                @foreach($mapel as $m)
                                <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block">Nilai</label>
                            <input type="number" name="nilai" required min="0" max="100" class="w-full border px-3 py-2">
                        </div>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>