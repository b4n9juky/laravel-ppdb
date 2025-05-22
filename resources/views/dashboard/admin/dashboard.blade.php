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
                <h2 class="text-xl font-semibold text-gray-700">Total Pendaftar</h2>
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
                            <td class="px-4 py-2">{{ $jalur->jalur_count }}</td>
                            <td class="px-4 py-2">{{ $jalur->sisa_kuota }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                </p>
            </div>


            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Statistik Pendaftar per Jalur</h2>
                <canvas id="jalurChart" class="w-full h-64"></canvas>

            </div>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const jalurLabels = @json($pendaftarPerJalur-> pluck('nama_jalur'));
        const jalurData = @json($pendaftarPerJalur-> pluck('total'));

        const ctx = document.getElementById('jalurChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: jalurLabels,
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: jalurData,
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>


</x-app-layout>