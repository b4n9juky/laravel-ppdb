<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1: Users -->
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700">Total Users</h2>
                <p class="text-3xl font-bold text-blue-600 mt-2">
                    {{ $jumlahPendaftar }}
                </p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700">Total Users</h2>
                <p class="text-3xl font-bold text-blue-600 mt-2">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-200 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-2">Jalur</th>
                            <th class="px-4 py-2">Kuota</th>
                            <th class="px-4 py-2">Terisi</th>
                            <th class="px-4 py-2">Sisa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jalurs as $jalur)
                        <tr class="bg-white border-b hover:bg-gray-100">
                            <td class="px-4 py-2">{{ $jalur->nama_jalur }}</td>
                            <td class="px-4 py-2">{{ $jalur->kuota }}</td>
                            <td class="px-4 py-2">{{ $jalur->pendaftars_count }}</td>
                            <td class="px-4 py-2">{{ $jalur->sisa_kuota }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                </p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700">Total Users</h2>
                <p class="text-3xl font-bold text-blue-600 mt-2">
                    {{ $jumlahPendaftar }}
                </p>
            </div>


            <!-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($jalurs as $jalur)
                <div class="bg-white shadow rounded-xl p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-indigo-700 mb-2">{{ $jalur->nama_jalur }}</h2>
                    <p class="text-sm text-gray-600">Kuota: <span class="font-medium text-gray-800">{{ $jalur->kuota }}</span></p>
                    <p class="text-sm text-gray-600">Terpakai: <span class="font-medium text-yellow-600">{{ $jalur->pendaftars_count }}</span></p>
                    <p class="text-sm text-gray-600">Sisa Kuota: <span class="font-medium text-green-600">{{ $jalur->sisa_kuota }}</span></p>
                </div>
                @endforeach
            </div> -->










            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700">Total Orders</h2>
                <p class="text-3xl font-bold text-green-600 mt-2">
                <ul>
                    @foreach ($kuotaPerJalur as $jalur)
                    <li>{{ $jalur->nama_jalur }}: {{ $jalur->kuota }} kuota</li>
                    @endforeach
                </ul>
                </p>
            </div>

            <!-- Card 3: Revenue -->
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700">Total Revenue</h2>
                <p class="text-3xl font-bold text-yellow-600 mt-2"></p>
            </div>
        </div>
    </div>

</x-app-layout>