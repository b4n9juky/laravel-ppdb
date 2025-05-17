<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Berkas Pendaftaran') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
            @endif

            @if ($berkas->isEmpty())
            <p class="text-gray-600">Anda belum mengupload berkas apa pun.</p>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 border">Jenis Berkas</th>
                            <th class="px-4 py-2 border">Lihat File</th>
                            <th class="px-4 py-2 border">Tanggal Upload</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($berkas as $item)
                        <tr>
                            <td class="px-4 py-2 border text-center">{{ strtoupper($item->jenis_berkas) }}</td>
                            <td class="px-4 py-2 border text-center">
                                <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank"
                                    class="text-blue-500 underline">Lihat</a>
                            </td>
                            <td class="px-4 py-2 border text-center">{{ $item->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <div class="mt-6">
                <a href="{{ route('user.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>