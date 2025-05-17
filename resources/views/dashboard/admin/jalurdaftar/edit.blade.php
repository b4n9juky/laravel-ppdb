<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jalur Pendaftaran') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                    <div class="text-green-600 mb-4">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('jalurdaftar.update') }}" method="POST">
                        @csrf

                        <div class="overflow-auto">
                            <table class="w-full text-sm text-left text-gray-700">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3">Jalur Daftar</th>
                                        <th class="px-6 py-3">Kuota</th>
                                        <th class="px-6 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($data as $row)
                                    <tr>
                                        <td class="border px-6 py-4">
                                            <input type="hidden" name="items[{{ $row->id }}][id]" value="{{ $row->id }}">
                                            <input type="text" name="items[{{ $row->id }}][nama_jalur]" value="{{ $row->nama_jalur }}">
                                        </td>
                                        <td class="border px-6 py-4">
                                            <input type="number" name="items[{{ $row->id }}][kuota]" value="{{ $row->kuota }}"
                                                class="border border-gray-300 rounded px-2 py-1 w-24">
                                        </td>
                                        <td class="border px-6 py-4">
                                            <input type="number" name="items[{{ $row->id }}][is_active]" value="{{ $row->is_active }}"
                                                class="border border-gray-300 rounded px-2 py-1 w-24">
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan Semua</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>