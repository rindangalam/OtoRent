@props(['title' => '', 'value' => '', 'icon' => null, 'color' => 'primary'])

@php
    $colorClasses = [
        'primary' => 'bg-primary/10 text-primary',
        'accent' => 'bg-accent/10 text-accent',
        'green' => 'bg-status-success/10 text-status-success',
        'red' => 'bg-status-danger/10 text-status-danger',
        'blue' => 'bg-info/10 text-info',
        'indigo' => 'bg-primary/10 text-primary',
        'amber' => 'bg-accent/10 text-accent',
        'gray' => 'bg-surface-container text-on-surface-variant',
    ];

    $iconBg = $colorClasses[$color] ?? $colorClasses['primary'];
@endphp

<div class="bg-surface-container-lowest rounded-xl border border-outline-variant/20 p-6">
    <div class="flex items-center gap-4">
        @if($icon)
            <div class="w-12 h-12 rounded-lg {{ $iconBg }} flex items-center justify-center shrink-0">
                {!! $icon !!}
            </div>
        @endif
        <div class="{{ $icon ? '' : 'text-center w-full' }}">
            <p class="text-3xl font-bold text-on-surface">{{ $value }}</p>
            <p class="text-sm text-on-surface-variant mt-1">{{ $title }}</p>
        </div>
    </div>
</div>
