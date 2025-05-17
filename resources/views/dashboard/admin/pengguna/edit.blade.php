<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Pengguna') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{route('pengguna.update', $user->id)}}" method="POST">
                        @csrf @method('PUT')

                        <select name="role" class="border rounded px-3 py-2 w-full">
                            @foreach(\App\Enums\UserRole::cases() as $role)
                            <option value="{{ $role->value }}" {{ $user->role === $role ? 'selected' : '' }}>
                                {{ ucfirst($role->value) }}
                            </option>
                            @endforeach
                        </select>



                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                    </form>
                </div>
</x-app-layout>