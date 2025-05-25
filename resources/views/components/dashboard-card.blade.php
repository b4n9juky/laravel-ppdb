@props(['value', 'label', 'color', 'icon'])

<div class="flex items-center p-4 rounded-xl shadow-md {{ $color }} text-white w-full">
    <div class="flex-1">
        <h2 class="text-2xl font-bold">{{ $value }}</h2>
        <p class="text-sm">{{ $label }}</p>
        <p class="text-sm">{{ $text }}</p>
        <a href="#" class="text-xs underline mt-2 inline-block">More info <i data-feather="arrow-right"></i></a>
    </div>
    <div class="text-4xl opacity-30 ml-4">
        <i data-feather="{{ $icon }}" class="w-10 h-10"></i>
    </div>
</div>