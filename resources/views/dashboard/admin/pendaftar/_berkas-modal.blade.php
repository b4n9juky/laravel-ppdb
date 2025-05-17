<h2 class="text-xl font-semibold mb-4">Berkas {{ $pendaftar->nama_lengkap }}</h2>
<ul class="list-disc pl-4">
    @foreach ($pendaftar->berkas as $berkas)
    <li class="mb-2">
        <a href="{{ asset('storage/'.$berkas->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
            {{ $berkas->jenis_berkas }}
        </a>
    </li>
    @endforeach
</ul>