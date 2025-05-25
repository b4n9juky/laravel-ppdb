@php
$label = [
'Diterima' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'check-circle'],
'Cadangan' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'icon' => 'clock'],
'Ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'x-circle'],
'Menunggu' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'help-circle'],
];

$info = $label[$status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'help-circle'];
@endphp

<span class="inline-flex items-center px-2 py-1 {{ $info['bg'] }} {{ $info['text'] }} text-sm rounded">
    <i data-feather="{{ $info['icon'] }}" class="w-4 h-4 mr-1"></i> {{ $status }}
</span>