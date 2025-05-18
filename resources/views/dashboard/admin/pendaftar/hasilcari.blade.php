@foreach ($siswa as $row)

<tr>
    <td class="px-4 py-2 border text-left text-xs uppercase">{{ $loop->iteration  }}</td>
    <td class="px-4 py-2 border text-left text-xs uppercase">{{ $row->jalur->nama_jalur ?? '-'  }}</td>
    <td class="px-4 py-2 border text-left text-xs uppercase">{{ $row->nama_lengkap }}</td>
    <td class="px-4 py-2 border text-left text-xs uppercase">{{ $row->sekolah_asal }}</td>
    <td class="px-4 py-2 border text-center"><a href="{{ route('siswa.status', $row->id) }}" class="text-blue-500 mr-2">
            @if($row->status =='Cadangan')
            <x-warning-button>{{ $row->status }}</x-warning-button> </a>
        @elseif($row->status =='Menunggu')
        <x-info-button>{{ $row->status }}</x-info-button></a>

        @else
        <x-success-button>{{ $row->status }}</x-success-button></a>
        @endif
    </td>
    <td class="px-4 py-2 border text-center"><a href="{{route('siswa.editnilai',$row->id)}}">
            <x-primary-button>{{$row->total_nilai ?? 0}}</x-primary-button>
        </a></td>
    <td class="px-4 py-2 border text-left text-xs uppercase">{{ $row->created_at->format('d M Y H:i') }}</td>
    <td class="px-4 py-2 border text-center">

        @foreach($row->berkas as $file)

        <a href="{{ asset('storage/' . $file->file_path) }}" data-lightbox="{{$file->file_path}}" class="flex"><i data-feather="image"></i>{{$file->jenis_berkas}}</a>
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
@endforeach