@props(['title' => '', 'value' => '', 'icon' => null, 'color' => 'primary'])

@php
    $colorClasses = [
        'primary' => 'bg-primary-50 text-primary-600',
        'accent' => 'bg-accent-50 text-accent-600',
        'green' => 'bg-green-50 text-green-600',
        'red' => 'bg-red-50 text-red-600',
        'blue' => 'bg-blue-50 text-blue-600',
        'indigo' => 'bg-indigo-50 text-indigo-600',
        'amber' => 'bg-amber-50 text-amber-600',
        'gray' => 'bg-gray-50 text-gray-600',
    ];

    $iconBg = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

<div class="bg-white rounded-xl border border-gray-200 p-6">
    <div class="flex items-center gap-4">
        @if($icon)
            <div class="w-12 h-12 rounded-lg {{ $iconBg }} flex items-center justify-center shrink-0">
                {!! $icon !!}
            </div>
        @endif
        <div class="{{ $icon ? '' : 'text-center w-full' }}">
            <p class="text-3xl font-bold text-gray-900">{{ $value }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $title }}</p>
        </div>
    </div>
</div>
