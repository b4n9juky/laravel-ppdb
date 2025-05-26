<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
            $colors = ['bg-sky-500','bg-green-500','bg-yellow-500','bg-red-500','bg-teal-500','bg-violet-500'];
            $icons = ['shopping-bag','bar-chart-2','user-plus','book-open','users','book'];
            @endphp

            @foreach($jalurs as $index => $jalur)
            <x-dashboard-card
                value="{{ $jalur->nama_jalur }}"
                text="{{ $jalur->jalur_count }} Pendaftar"
                label="{{ $jalur->sisa_kuota}} Kuota"
                color="{{ $colors[$index % count($colors)] }}"
                icon="{{ $icons[$index % count($icons)] }}" />

            @endforeach

        </div>

    </div>

    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">

            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Statistik Pendaftar per Jalur</h2>
                <canvas id="jalurChart" class="w-full"></canvas>

            </div>
            <!-- // menampilkan 10 user terbaru -->
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">10 Pendaftar Terbaru</h2>
                <table class="table-auto w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestUsers as $user)
                        <tr>
                            <td class="border px-4 py-2 text-sm">{{ $user->name }}</td>
                            <td class="border px-4 py-2 text-sm">{{ $user->email }}</td>
                            <td class="border px-4 py-2 text-sm">{{ $user->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-2">Belum ada pendaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

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