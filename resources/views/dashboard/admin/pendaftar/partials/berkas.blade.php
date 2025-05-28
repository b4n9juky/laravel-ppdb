@foreach ($berkasList as $berkas)
@php
$url = asset('storage/' . $berkas->file_path);
$ext = strtolower(pathinfo($berkas->file_path, PATHINFO_EXTENSION));
@endphp

@if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))

<a href="{{ $url }}" data-lightbox="berkas-{{ $itemId }}" data-title="{{ $berkas->jenis_berkas }}">
    <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 text-sm uppercase rounded mr-1 mb-1 hover:underline cursor-pointer">
        {{ $berkas->jenis_berkas }}
    </span>
</a>
@elseif ($ext === 'pdf')
<a href="{{ $url }}" target="_blank">
    <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 text-sm uppercase rounded mr-1 mb-1 hover:underline cursor-pointer">
        {{ $berkas->jenis_berkas }}
    </span>
</a>
@else
<a href="{{ $url }}" target="_blank" class="text-blue-600 hover:underline mr-2">Download File</a>
@endif
@endforeach