<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (auth()->user()->pendaftaran)
                    <p class="mb-4">Status Pendaftaran Anda: <strong>{{ auth()->user()->pendaftaran->status }}</strong></p>

                    <a href="{{ route('pendaftar.cetak', auth()->user()->pendaftaran->id) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Cetak Bukti Pendaftaran
                    </a>
                    @else
                    <p class="mb-4">Anda belum mengisi Formulir pendaftaran.</p>

                    <a href="{{ route('formulir') }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Isi Formulir Pendaftaran
                    </a>
                    @endif
                </div>
            </div>
        </div>

    </div>



</x-app-layout>