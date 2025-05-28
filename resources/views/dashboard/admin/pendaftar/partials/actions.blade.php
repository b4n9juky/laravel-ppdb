<div class="flex space-x-2">


    @if($item->status ==='Ditolak')
    {{-- Approve --}}
    <form action="{{ route('pendaftar.approve', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin memproses?')">
        @csrf
        <button class="inline-flex items-center px-2 py-1 text-white bg-green-600 hover:bg-green-700 rounded text-sm" disabled>
            <i data-feather="check" class="w-4 h-4 mr-1"></i> Approve
        </button>
    </form>

    {{-- Batal --}}
    <form action="{{ route('pendaftar.batal', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan?')">
        @csrf
        <button type="submit" class="inline-flex items-center px-2 py-1 text-white bg-red-600 hover:bg-red-700 rounded text-sm">
            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Batal
        </button>
    </form>

    {{-- Edit Nilai --}}
    <a href="#" class="inline-flex items-center px-2 py-1 text-white bg-blue-600 hover:bg-blue-700 rounded text-sm">
        <i data-feather="edit" class="w-4 h-4 mr-1"></i> Nilai
    </a>

    {{-- Cetak --}}
    <a href="#" class="inline-flex items-center px-2 py-1 text-white bg-black hover:bg-gray-800 rounded text-sm">
        <i data-feather="printer" class="w-4 h-4 mr-1"></i> Cetak
    </a>
    @else
    {{-- Approve --}}
    <form action="{{ route('pendaftar.approve', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin memproses?')">
        @csrf
        <button class="inline-flex items-center px-2 py-1 text-white bg-green-600 hover:bg-green-700 rounded text-sm">
            <i data-feather="check" class="w-4 h-4 mr-1"></i> Approve
        </button>
    </form>

    {{-- Batal --}}
    <form action="{{ route('pendaftar.batal', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan?')">
        @csrf
        <button type="submit" class="inline-flex items-center px-2 py-1 text-white bg-red-600 hover:bg-red-700 rounded text-sm">
            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Batal
        </button>
    </form>

    {{-- Edit Nilai --}}
    <a href="{{ route('siswa.editnilai', $item->id) }}" class="inline-flex items-center px-2 py-1 text-white bg-blue-600 hover:bg-blue-700 rounded text-sm">
        <i data-feather="edit" class="w-4 h-4 mr-1"></i> Nilai
    </a>

    {{-- Cetak --}}
    <a href="{{ route('admin.cetak', $item->id) }}" class="inline-flex items-center px-2 py-1 text-white bg-black hover:bg-gray-800 rounded text-sm" target="_blank">
        <i data-feather="printer" class="w-4 h-4 mr-1"></i> Cetak
    </a>
    @endif

</div>