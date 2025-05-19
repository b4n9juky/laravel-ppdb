<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-xl mx-auto mt-10">
                <h2 class="text-2xl font-bold mb-4">Reset Password: {{ $user->name }}</h2>

                <form action="{{ route('admin.users.updatePassword', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="password" class="block font-semibold">Password Baru</label>
                        <input type="password" name="password" id="password" class="w-full border px-4 py-2 mt-1" required>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block font-semibold">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border px-4 py-2 mt-1" required>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Reset Password</button>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>