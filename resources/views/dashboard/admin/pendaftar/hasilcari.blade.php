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
        <ul class="list-disc list-inside text-left text-xs uppercase">

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

            <x-primary-button type="submit">Proses</x-primary-button>
        </form>
        <form action="{{ route('pendaftar.batal', $row->id) }}" method="POST">
            @csrf

            <x-danger-button type="submit">Batal</x-danger-button>
        </form>



    </td>
</tr>
@endforeach