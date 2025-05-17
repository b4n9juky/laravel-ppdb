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
                <p class="text-3xl font-bold text-blue-600 mt-2"></p>
            </div>

            <!-- Card 2: Orders -->




            <div class="mb-4 p-4 border rounded">
                <h3 class="text-lg font-semibold"></h3>
                <p></p>
                <p></p>
                <p></p>
            </div>








            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700">Total Orders</h2>
                <p class="text-3xl font-bold text-green-600 mt-2"></p>
            </div>

            <!-- Card 3: Revenue -->
            <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700">Total Revenue</h2>
                <p class="text-3xl font-bold text-yellow-600 mt-2"></p>
            </div>
        </div>
    </div>

</x-app-layout>