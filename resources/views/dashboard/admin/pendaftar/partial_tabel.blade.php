<table class="min-w-full table-auto">
    <thead>
        <tr>
            <th class="px-4 py-2 border">No</th>
            <th class="px-4 py-2 border">Jalur Daftar</th>
            <th class="px-4 py-2 border">Nama</th>
            <th class="px-4 py-2 border">Asal Sekolah</th>
            <th class="px-4 py-2 border">Status Daftar</th>
            <th class="px-4 py-2 border">Total Nilai</th>
            <th class="px-4 py-2 border">Waktu Pendaftaran</th>
            <th class="px-4 py-2 border">Berkas</th>
            <th class="px-4 py-2 border" colspan="2">Atur</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($siswa as $row)
        <tr>
            <td class="px-4 py-2 border text-center">{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</td>
            <td class="px-4 py-2 border text-center">{{ $row->jalur->nama_jalur ?? '-'  }}</td>
            <td class="px-4 py-2 border text-center">{{ $row->nama_lengkap }}</td>
            <td class="px-4 py-2 border text-center">{{ $row->sekolah_asal }}</td>
            <td class="px-4 py-2 border text-center">
                @if($row->status == 'Cadangan')
                <x-warning-button>{{ $row->status }}</x-warning-button>
                @elseif($row->status == 'Menunggu')
                <x-info-button>{{ $row->status }}</x-info-button>
                @else
                <x-success-button>{{ $row->status }}</x-success-button>
                @endif
            </td>
            <td class="px-4 py-2 border text-center">
                <a href="{{ route('siswa.editnilai', $row->id) }}">
                    <x-primary-button>{{ $row->total_nilai ?? 0 }}</x-primary-button>
                </a>
            </td>
            <td class="px-4 py-2 border text-center">{{ $row->created_at->format('d M Y H:i') }}</td>
            <td class="px-4 py-2 border text-center">
                @foreach($row->berkas as $file)
                <ul class="list-disc list-inside text-left">
                    <li>
                        <a href="#" class="lihat-berkas text-blue-600" data-id="{{ $row->id }}">
                            {{ $file->jenis_berkas }}
                        </a>
                    </li>
                </ul>
                @endforeach
            </td>
            <td class="px-4 py-2 border text-center">
                <form action="{{ route('pendaftar.approve', $row->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1 bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700">
                        <i data-feather="check"></i> <!-- Feather icon -->

                    </button>
                </form>
            </td>
            <td class="px-4 py-2 border text-center">
                <form action="{{ route('pendaftar.batal', $row->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1 bg-red-600 text-white px-3 py-2 rounded hover:bg-blue-700">
                        <i data-feather="x-circle"></i> <!-- Feather icon -->

                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center text-gray-500 py-4">Belum ada siswa pada jalur ini.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-6">
    {{ $siswa->links() }}
</div>