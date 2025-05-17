@php
$steps = ['Isi Formulir', 'Isi Nilai', 'Upload Berkas'];
@endphp

<div class="mb-4">
    <div class="flex items-center justify-between text-sm font-medium">
        @foreach ($steps as $index => $label)
        <div class="flex-1 text-center {{ $step == $index + 1 ? 'text-blue-600 font-bold' : 'text-gray-400' }}">
            {{ $label }}
            <div class="text-xs">
                Proses {{ $index + 1 }} dari {{ count($steps) }}
            </div>
        </div>
        @if ($index < count($steps) - 1)
            <div class="w-4 h-1 bg-gray-300 mx-2 {{ $step > $index + 1 ? 'bg-blue-600' : '' }}">
    </div>
    @endif
    @endforeach
</div>
</div>