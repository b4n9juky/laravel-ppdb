<div class="flex space-x-2">
    <form action="{{ route('pengguna.hapus', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan?')">
        @csrf @method('DELETE')
        <button type="submit"
            class="inline-flex items-center px-2 py-1 text-white bg-red-600 hover:bg-red-700 rounded text-sm">
            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Hapus
        </button>
    </form>
    <a href="{{ route('admin.users.editPassword', $user->id) }}"
        class="inline-flex items-center px-2 py-1 text-white bg-blue-600 hover:bg-red-700 rounded text-sm">
        <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reset
    </a>
    <a href="{{ route('pengguna.edit', $user->id) }}"
        class="inline-flex items-center px-2 py-1 text-white bg-blue-600 hover:bg-red-700 rounded text-sm">
        <i data-feather="edit" class="w-4 h-4 mr-1"></i> Peran
    </a>
</div>