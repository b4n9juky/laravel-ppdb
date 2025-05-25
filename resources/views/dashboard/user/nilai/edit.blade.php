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
                    <form action="{{ route('nilai.update', $nilai->id) }}" method="POST">
                        @csrf @method('PUT')

                        <div class="mb-4">
                            <label class="block">Mata Pelajaran</label>
                            <select name="mapel_id" required class="border rounded px-3 py-2 w-full">
                                @foreach($mapel as $m)
                                <option value="{{ $m->id }}" {{ $nilai->mapel_id == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama_mapel }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block">Nilai</label>
                            <input type="number" name="nilai" value="{{ $nilai->nilai }}" required min="0" max="100" class="w-full border px-3 py-2">
                        </div>

                        <x-info-button type="submit">Update</x-info-button>
                        <x-secondary-button onclick="window.history.back();">Batal</x-secondary-button>

                    </form>
                </div>
</x-app-layout>